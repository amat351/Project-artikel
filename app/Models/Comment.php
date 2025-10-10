<?php

namespace App\Models;
use App\Models\Post;
use App\Models\User;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'body',
    ];

    protected $casts = [
        'body' => 'array', // Opsional: Jika ingin store HTML sanitized, tapi text biasa OK
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies'); // Recursive untuk nested
    }

    // Scope untuk komentar utama (level 1)
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    // Helper: Cek apakah ini reply
    public function isReply()
    {
        return !is_null($this->parent_id);
    }
}