<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasContentRelations;
use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasContentRelations, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'github_url',
        'category_id',
        'published_at',
    ];

    protected $casts = [
        'status' => ContentStatus::class,
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
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
        return true;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
