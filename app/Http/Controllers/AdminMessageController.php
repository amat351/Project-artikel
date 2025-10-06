<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->paginate(10)->withQueryString();
        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $thread = $message->thread();  // Load pesan + replies
        if ($message->sender_type === 'user') {
            $message->update(['is_read' => true]);  // Mark as read
            $message->replies()->update(['is_read' => true]);
        }
        return view('admin.messages.show', compact('message', 'thread'));
    }

    public function reply(Request $request, Message $message)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        Message::create([
            'user_id' => $message->user_id,
            'parent_id' => $message->id,
            'body' => $request->body,
            'sender_type' => 'admin',
            'sender_id' => Auth::id(),
            'name' => Auth::user()->name,
            'username' => Auth::user()->username,
            'email' => Auth::user()->email,
        ]);

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Balasan berhasil dikirim!');
    }

    public function destroy(Message $message)
    {
        // Admin hanya bisa delete reply mereka sendiri atau pesan user (tapi cascade replies)
        if ($message->sender_type === 'admin' && $message->sender_id !== Auth::id()) {
            abort(403, 'Hanya bisa hapus balasan sendiri.');
        }

        if ($message->parent_id === null) {
            $message->replies()->delete();  // Hapus seluruh thread jika pesan utama
        }
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan dihapus!');
    }
}

