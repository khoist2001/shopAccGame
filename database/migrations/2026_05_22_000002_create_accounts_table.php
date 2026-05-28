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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->decimal('price', 15, 2);
            $table->string('rank')->nullable();
            $table->string('status')->default('available'); // available, sold
            $table->text('images')->nullable(); // JSON array of images
            $table->text('description')->nullable();
            $table->text('login_details')->nullable(); // Hidden credentials shown after purchase
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
