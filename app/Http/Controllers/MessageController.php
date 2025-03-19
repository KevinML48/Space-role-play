<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Salon;

class MessageController extends Controller
{
    public function index(Salon $salon)
    {
        $messages = Message::where('salon_id', $salon->id)->with('user')->get();
        return view('messages.index', compact('messages', 'salon'));
    }

    public function store(Request $request, Salon $salon)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Message::create([
            'user_id' => auth()->id(),
            'salon_id' => $salon->id,
            'content' => $request->content,
        ]);

        return redirect()->route('messages.index', $salon)->with('success', 'Message sent!');
    }
}
