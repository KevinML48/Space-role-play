<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ServerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userServers = $user->servers;
        
        // Serveurs non rejoints
        $allServers = Server::whereDoesntHave('users', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })->get();

        return view('servers.index', compact('userServers', 'allServers'));
    }

    public function create()
    {
        return view('servers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:servers',
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|max:2048',
            'short_description' => 'nullable|string|max:255',
        ]);

        $server = Server::create([
            'name' => $request->name,
            'code' => $request->code,
            'password' => $request->password ? bcrypt($request->password) : null,
            'image' => $request->hasFile('image') 
                ? $request->file('image')->store('servers', 'public')
                : null,
            'short_description' => $request->short_description,
        ]);

        auth()->user()->servers()->attach($server);

        return redirect()->route('servers.show', $server);
    }

    public function show(Server $server)
    {
        $categories = $server->categories()->with('channels')->get();
        return view('servers.show', compact('server', 'categories'));
    }

    public function join(Request $request)
    {
        $server = Server::findOrFail($request->server_id);

        $request->validate([
            'server_id' => 'required|exists:servers,id',
            'code' => [
                'nullable',
                'string',
                Rule::requiredIf(fn () => $server->code !== null)
            ],
            'password' => [
                'nullable',
                'string',
                Rule::requiredIf(fn () => $server->password !== null)
            ],
        ]);

        // Vérification code
        if ($server->code && $server->code !== $request->code) {
            return back()->with('error', 'Code incorrect');
        }

        // Vérification mot de passe
        if ($server->password && !Hash::check($request->password, $server->password)) {
            return back()->with('error', 'Mot de passe incorrect');
        }

        auth()->user()->servers()->attach($server);
        return redirect()->route('servers.show', $server);
    }

    public function edit(Server $server)
    {
        return view('servers.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:servers,code,'.$server->id,
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|max:2048',
            'short_description' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['name', 'code', 'short_description']);
        
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            if ($server->image) {
                Storage::disk('public')->delete($server->image);
            }
            $data['image'] = $request->file('image')->store('servers', 'public');
        }

        $server->update($data);

        return redirect()->route('servers.show', $server);
    }

    public function destroy(Server $server)
    {
        if ($server->image) {
            Storage::disk('public')->delete($server->image);
        }
        
        $server->delete();
        return redirect()->route('servers.index');
    }
}
