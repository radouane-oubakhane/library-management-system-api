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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('book_copy_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('member_id')->constrained();
            $table->date('borrow_date');
            $table->date('return_date');
            $table->enum('status', ['borrowed', 'returned', 'overdue']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
