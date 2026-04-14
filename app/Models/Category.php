<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
