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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->varchar('make', 100);
            $table->varchar('model', 100);
            $table->integer('year');
            $table->varchar('color', 50)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('mileage')->default(0);
            $table->varchar('vin', 17)->unique();
            $table->varchar('fuel_type', 20)->nullable();
            $table->varchar('transmission', 20)->nullable();
            $table->date('registration_date')->nullable();
            $table->boolean('is_used')->default(true);
            $table->timestamps(); // Opcional: añade created_at y updated_at
            $table->softDeletes(); // Opcional: añade deleted_at para soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car');
    }
};
