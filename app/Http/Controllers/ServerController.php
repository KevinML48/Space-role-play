<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class ServerController extends BaseController
{
    public function index()
    {
        $userServers = auth()->user()->servers;
        $allServers = Server::whereNotIn('id', $userServers->pluck('id'))->get();
        return view('servers.index', compact('userServers', 'allServers'));
    }

    public function create()
    {
        \Log::info('Create method reached');
        return view('servers.create');
    }    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:servers',
            'image' => 'nullable|image|max:2048', // max 2Mo
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('servers', 'public');
        }
    
        $server = Server::create([
            'name' => $request->name,
            'code' => $request->code ?? Str::random(8),
            'image' => $imagePath,
        ]);
    
        auth()->user()->servers()->attach($server);
    
        return redirect()->route('servers.show', $server)->with('success', 'Serveur créé avec succès.');
    }    

    public function show(Server $server)
    {
        $categories = $server->categories()->with('channels')->get();
        return view('servers.show', compact('server', 'categories'));
    }

    public function join(Request $request)
    {
        $request->validate([
            'server_id' => 'required|exists:servers,id',
            'code' => 'required|string',
        ]);

        $server = Server::findOrFail($request->server_id);

        if ($server->code !== $request->code) {
            return back()->with('error', 'Code incorrect');
        }

        auth()->user()->servers()->attach($server);

        return redirect()->route('servers.show', $server)->with('success', 'Vous avez rejoint le serveur.');
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
        'image' => 'nullable|image|max:2048', // max 2Mo
    ]);

    $data = [
        'name' => $request->name,
        'code' => $request->code,
    ];

    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image si elle existe
        if ($server->image) {
            Storage::disk('public')->delete($server->image);
        }
        $data['image'] = $request->file('image')->store('servers', 'public');
    }

    $server->update($data);

    return redirect()->route('servers.show', $server)->with('success', 'Serveur mis à jour avec succès.');
}

}
