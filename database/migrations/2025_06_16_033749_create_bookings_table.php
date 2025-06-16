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
        Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('booking_date');
        $table->time('booking_time');
        $table->enum('vehicle_type', ['motor', 'mobil']);
        $table->decimal('price', 10, 2);
        $table->enum('payment_method', ['cash', 'transfer']);
        $table->timestamps();

        $table->unique(['booking_date', 'booking_time']); // Cegah booking dobel di slot sama
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
