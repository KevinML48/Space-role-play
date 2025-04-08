<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;

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
        ]);

        $server = Server::create([
            'name' => $request->name,
            'code' => $request->code ?? Str::random(8),
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
}
