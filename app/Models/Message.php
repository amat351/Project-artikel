<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name', 'username', 'email', 'body', 'parent_id', 'sender_type', 'sender_id', 'is_read'
    ];

    // Relasi: Pesan asli (parent)
    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    // Relasi: Balasan (replies)
    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id')->orderBy('created_at');
    }

    // Relasi: Pengirim (user/admin)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Scope: Hanya pesan utama (bukan reply)
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    // Scope: Pesan dari user (untuk admin index)
    public function scopeIncoming($query)
    {
        return $query->where('sender_type', 'user');
    }

    // Helper: Load full thread
    public function thread()
    {
        return $this->load('replies.sender');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
