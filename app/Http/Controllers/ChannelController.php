<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ChannelController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['store']);
    }

    public function store(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $channel = $category->channels()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('servers.show', $category->server)->with('success', 'Salon créé avec succès.');
    }

    public function show(Channel $channel)
    {
        $messages = $channel->messages()->with('user')->orderBy('created_at', 'asc')->get();
        return view('channels.show', compact('channel', 'messages'));
    }
}
