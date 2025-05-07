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
        Schema::create('clothes', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('brand', 50);
            $table->string('color', 20);
            $table->string('size', 10);
            $table->decimal('price', 10, 2);  
            $table->string('material', 50);
            $table->string('gender', 10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothes');
    }
};
