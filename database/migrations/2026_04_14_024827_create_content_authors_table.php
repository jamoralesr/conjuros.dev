<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_authors', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->morphs('authorable');
            $table->primary(['author_id', 'authorable_id', 'authorable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_authors');
    }
};
