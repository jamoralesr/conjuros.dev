<?php

namespace App\Models;

use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function tutorials(): MorphToMany
    {
        return $this->morphedByMany(Tutorial::class, 'taggable');
    }

    public function courses(): MorphToMany
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }

    public function resources(): MorphToMany
    {
        return $this->morphedByMany(Resource::class, 'taggable');
    }
}
