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
    Schema::create('qr_visits', function (Blueprint $table) {
        $table->id();
        $table->foreignId('qr_link_id')->constrained()->cascadeOnDelete();
        $table->string('ip_address')->nullable();
        $table->string('device_type')->nullable(); // Mobile, Desktop, Tablet
        $table->string('os')->nullable(); // iOS, Android, Windows
        $table->string('browser')->nullable(); // Chrome, Safari
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_visits');
    }
};
