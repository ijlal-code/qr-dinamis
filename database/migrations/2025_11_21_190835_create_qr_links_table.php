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
    Schema::create('qr_links', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: "Kartu Nama Saya"
        $table->string('slug')->unique(); // Kode unik (misal: 'x7z9')
        $table->text('target_url'); // URL Tujuan (bisa diubah-ubah)
        $table->bigInteger('visit_count')->default(0); // Counter sederhana
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_links');
    }
};
