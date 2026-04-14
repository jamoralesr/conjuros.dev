<?php

namespace App\Models;

use App\Enums\AuthorType;
use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Author extends Model
{
    /** @use HasFactory<AuthorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'bio',
        'avatar',
        'type',
        'user_id',
    ];

    protected $casts = [
        'type' => AuthorType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'authorable', 'content_authors');
    }

    public function tutorials(): MorphToMany
    {
        return $this->morphedByMany(Tutorial::class, 'authorable', 'content_authors');
    }

    public function courses(): MorphToMany
    {
        return $this->morphedByMany(Course::class, 'authorable', 'content_authors');
    }
}
