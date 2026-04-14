<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resourceables', function (Blueprint $table) {
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->morphs('resourceable');
            $table->primary(['resource_id', 'resourceable_id', 'resourceable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resourceables');
    }
};
