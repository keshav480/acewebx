<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');         // Page title
            $table->string('slug')->unique(); // URL-friendly slug
            $table->text('content')->nullable(); // Page content
            $table->enum('status', ['draft', 'published'])->default('draft'); // Page status
            $table->integer('order')->default(0); // Optional order for sorting
            $table->timestamps();            // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
