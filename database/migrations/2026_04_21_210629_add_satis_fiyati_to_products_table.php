<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. (Veritabanına ekleme yaparken çalışır)
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // alis_fiyati sütunundan hemen sonra satis_fiyati sütununu ekliyoruz
            // default(0) dedik ki eski kayıtlar hata vermesin, 0 olarak başlasın
            $table->decimal('satis_fiyati', 10, 2)->after('alis_fiyati')->default(0);
        });
    }

    /**
     * Reverse the migrations. (Eğer işlemi geri alırsak çalışır)
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // İşlemi geri alırsak eklediğimiz sütunu siliyoruz
            $table->dropColumn('satis_fiyati');
        });
    }
};