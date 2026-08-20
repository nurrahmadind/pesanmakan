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
       Schema::create('foods', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name');
            $table->enum('category', ['Makanan', 'Minuman', 'Cemilan']);
            $table->integer('price');
            $table->text('description');
            $table->string('image')->nullable(); // Boleh kosong/null
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
