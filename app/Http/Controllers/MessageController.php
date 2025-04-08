<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Channel $channel)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message = $channel->messages()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('channels.show', $channel)->with('success', 'Message envoyé.');
    }
}
