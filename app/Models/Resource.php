<?php

namespace App\Models;

use App\Enums\ContentAccess;
use App\Enums\ResourceType;
use Database\Factories\ResourceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Resource extends Model
{
    /** @use HasFactory<ResourceFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'body',
        'url',
        'description',
        'model',
        'access',
    ];

    protected $casts = [
        'type' => ResourceType::class,
        'access' => ContentAccess::class,
    ];

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'resourceable');
    }

    public function tutorials(): MorphToMany
    {
        return $this->morphedByMany(Tutorial::class, 'resourceable');
    }

    public function courses(): MorphToMany
    {
        return $this->morphedByMany(Course::class, 'resourceable');
    }

    public function lessons(): MorphToMany
    {
        return $this->morphedByMany(Lesson::class, 'resourceable');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
