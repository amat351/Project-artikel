<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'remember_token',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    // Messages yang dikirim user (untuk history)
    public function sentMessages()
    {
        return $this->messages()->where('sender_type', 'user');
    }

    public function posts() :HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }
    public function getRouteKeyName()
    {
        return 'username';
    }


    public function getAvatarUrlAttribute()
    {
    if (!empty($this->profile_photo) && \Storage::disk('public')->exists($this->profile_photo)) {
        return asset('storage/' . $this->profile_photo);
    }

    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff&size=128';
    }
}  
