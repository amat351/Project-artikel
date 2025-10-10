<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Query: Root messages yang dikirim user + load replies (dari admin)
        $threads = Message::root()  // Hanya pesan utama
            ->where('sender_id', Auth::id())  // Milik user ini
            ->with('replies.sender')  // Load balasan admin + sender info
            ->latest()  // Urut terbaru
            ->paginate(10);  // Pagination

        // Debug: Cek apakah $threads ada data (hapus setelah test)
        // dd($threads);  // Uncomment untuk debug di browser

        return view('user.messages.index', compact('threads'));  // Pastikan compact('threads')
    }

    public function show(Message $message)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check ownership: Hanya thread milik user
        if ($message->sender_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $thread = $message->load('replies.sender');  // Load thread
        $message->replies()->where('sender_type', 'admin')->update(['is_read' => true]);  // Mark admin replies as read

        return view('user.messages.show', compact('message', 'thread'));
    }
}