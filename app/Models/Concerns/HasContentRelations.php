<?php

namespace App\Models\Concerns;

use App\Models\Author;
use App\Models\Resource;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasContentRelations
{
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable', 'content_authors');
    }

    public function resources(): MorphToMany
    {
        return $this->morphToMany(Resource::class, 'resourceable');
    }
}
