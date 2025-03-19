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

    public function store(Request $request)
    {
        $request->validate([
            'salon_id' => 'required|exists:salons,id',
            'content' => 'required|string|max:255',
        ]);
    
        Message::create([
            'salon_id' => $request->salon_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);
    
        return redirect()->route('salons.show', $request->salon_id);
    }    
}
