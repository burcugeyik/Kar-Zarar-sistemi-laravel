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
       Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->string('baslik');    // Masrafın adı (Örn: Dükkan Kirası)
        $table->decimal('tutar', 15, 2); // Masrafın miktarı
        $table->string('kategori');  // Masrafın türü (Örn: Fatura, Kira, Mutfak)
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
