<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('author_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('book_category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('isbn')->unique();
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->string('publisher')->nullable();
            $table->date('published_at')->nullable();
            $table->string('language')->nullable();
            $table->string('edition')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
