<?php

namespace App\Models;

use App\Models\Concerns\HasContentRelations;
use Database\Factories\LessonFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    /** @use HasFactory<LessonFactory> */
    use HasContentRelations, HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'body',
        'order',
        'interactive_html_path',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'order' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
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
