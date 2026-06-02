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
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        // Hangi ürün satıldı? (Ürünler tablosuyla bağlıyoruz)
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->integer('adet'); // Kaç tane satıldı?
        $table->decimal('satis_fiyati', 10, 2); // O anki satış fiyatı
        $table->decimal('toplam_tutar', 10, 2); // adet * satis_fiyati
        $table->decimal('elde_edilen_kar', 10, 2); // Net kâr
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
