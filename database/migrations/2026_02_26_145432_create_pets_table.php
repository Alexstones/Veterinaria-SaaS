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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // adopcion, perdido, encontrado
            $table->string('species'); // perro, gato, otro
            $table->string('sex')->nullable();
            $table->string('size')->nullable();
            $table->string('age')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->json('contact_info')->nullable();
            $table->string('status')->default('pending'); // pending, active, rejected, closed
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
