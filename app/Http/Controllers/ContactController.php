<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;  // Untuk $admin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $user = Auth::user();  // Untuk settings

        // Load admin (asumsi ada user dengan is_admin=true; sesuaikan jika pakai config)
        $admin = User::where('is_admin', true)->first() ?? (object)[
            'name' => 'Muhammad Eka Nur Fauzi',
            'phone' => '+62 812-3456-7890',
            'email' => 'muhammadekanur@gmail.com'
        ];

        // Load riwayat singkat (5 terbaru)
        $threads = collect();  // Fallback empty
        if ($user) {
            $threads = Message::root()
                ->where('sender_id', $user->id)
                ->with('replies.sender')
                ->latest()
                ->limit(5)
                ->get();
        }

        return view('contact.index', compact('threads', 'admin', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login untuk mengirim pesan.');
    }

    $user = Auth::user();

    // Hitung pesan dalam 24 jam terakhir
    $countToday = \App\Models\Message::where('sender_id', $user->id)
        ->where('created_at', '>=', now()->subDay()) // 24 jam terakhir
        ->count();

    if ($countToday >= 3) {
        return redirect()->back()->with('error', 'Anda hanya bisa mengirim 3 pesan setiap 24 jam. Silakan coba lagi nanti.');
    }


        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengirim pesan.');
        }

        Message::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'username' => Auth::user()->username ?? '',
            'email' => Auth::user()->email,
            'body' => $request->body,
            'sender_type' => 'user',
            'sender_id' => Auth::id(),
        ]);

        return redirect()->route('contact.index')->with('success', 'Pesan berhasil dikirim!');
    }

    public function destroy(Message $message)
    {
        $user = Auth::user();

        // Pastikan hanya pemilik pesan yang bisa hapus
        if (!$user || $message->sender_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus pesan ini.');
        }

        // Hapus pesan beserta replies-nya (jika ada)
        $message->replies()->delete(); // Hapus balasan dulu, opsional
        $message->delete();

        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }
}