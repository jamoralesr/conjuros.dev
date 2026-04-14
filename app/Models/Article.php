<?php

namespace App\Models;

use App\Enums\ContentAccess;
use App\Enums\ContentStatus;
use App\Models\Concerns\HasContentRelations;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasContentRelations, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'access',
        'status',
        'category_id',
        'published_at',
    ];

    protected $casts = [
        'access' => ContentAccess::class,
        'status' => ContentStatus::class,
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ContentStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPro(): bool
    {
        return $this->access === ContentAccess::Pro;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
