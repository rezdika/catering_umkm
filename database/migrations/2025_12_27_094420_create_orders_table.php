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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->integer('total_quantity');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('delivery_fee', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->foreignId('delivery_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('delivery_area_id')->constrained()->onDelete('cascade');
            $table->text('delivery_address');
            $table->date('delivery_date');
            $table->time('delivery_time');
            $table->enum('status', ['pending', 'payment_verified', 'preparing', 'ready', 'on_delivery', 'delivered', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'verified', 'failed'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('assigned_kurir_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
