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
            $table->string('name', 100);
            $table->string('species', 50);
            $table->string('breed', 50);
            $table->integer('age');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['available', 'sold']);
            $table->string('detail', 250)->nullable();
            $table->string('photo', 100)->nullable();
            $table->timestamps();
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
