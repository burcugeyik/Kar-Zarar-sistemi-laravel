<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
    protected $fillable = [
    'user_id',
    'urun_adi',
    'alis_fiyati',
    'satis_fiyati',
    'stok_miktari',
    'kargo_ucreti',
    'kdv_orani'
];

// 1. Satıştan KDV'yi düşüp kargoyu çıkarınca elimize kalan net para
public function getNetKazancAttribute() {
    $kdv_tutari = $this->satis_fiyati * ($this->kdv_orani / 100);
    return $this->satis_fiyati - $kdv_tutari - $this->kargo_ucreti;
}

// 2. Saf Kar (Net Kazanç - Alış Fiyati)
public function getNetKarAttribute() {
    return $this->net_kazanc - $this->alis_fiyati;
}
public function user()
{
    return $this->belongsTo(User::class);
}
}