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
        Schema::create('delivery_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Motor, Mobil
            $table->integer('min_quantity'); // Motor: 10, Mobil: 11
            $table->integer('max_quantity')->nullable(); // Motor: 10, Mobil: null
            $table->decimal('base_price', 10, 2); // Harga dasar ongkir
            $table->decimal('price_per_km', 10, 2); // Harga per kilometer
            $table->enum('vehicle_type', ['motor', 'mobil']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_types');
    }
};
