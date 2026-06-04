<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // Laravel'in bu sütunlara veri yazmasına izin veriyoruz
    protected $fillable = [
    'user_id',
    'product_id',
    'adet',
    'satis_fiyati',
    'toplam_tutar',
    'elde_edilen_kar'
];

    // Ürün ile olan bağlantısı (Hoca sorarsa: Many-to-One ilişkisi)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}