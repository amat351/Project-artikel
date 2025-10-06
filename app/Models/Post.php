<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'body', 'photo', 'author_id', 'category_id'];
    protected $with = ['author', 'category'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('replies', 'user'); // Load nested replies & user
    }

    protected static function booted()
    {
        static::addGlobalScope('authorOnly', function (Builder $builder) {
            $builder->WhereHas('author', function ($query) {
                $query->whereIn('role', [ 'author', 'admin', 'superadmin']);
            });
        });
    }

    // ✅ Accessor untuk foto
    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            // fallback ke picsum random kalau kosong
            return 'https://picsum.photos/800/400?random=' . rand(1, 1000);
        }

        // kalau URL
        if (Str::startsWith($this->photo, 'http')) {
            return $this->photo;
        }

        // kalau file upload
        return asset('storage/' . $this->photo);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')
                ->orWhereHas('author', fn ($query) =>
                    $query->where('name', 'like', '%' . $search . '%'))
                ->orWhereHas('category', fn ($query) =>
                    $query->where('name', 'like', '%' . $search . '%'))
                ->orWhereHas('category', fn ($query) =>
                    $query->where('slug', 'like', '%' . $search . '%'))
                ->orWhereHas('author', fn ($query) =>
                    $query->where('username', 'like', '%' . $search . '%'))
                ->orWhereHas('author', fn ($query) =>
                    $query->where('email', 'like', '%' . $search . '%'))
                ->orWhereHas('author', fn ($query) =>
                    $query->where('id', 'like', '%' . $search . '%'))
        );
        $query->when(
            $filters['category'] ?? false,
            fn ($query, $category) =>
            $query->whereHas('category', fn ($query) =>
                $query->where('slug', $category)
            )
        );
        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas('author', fn ($query) =>
                $query->where('username', $author)
            )
        );
    }
}