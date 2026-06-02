<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 1. Siteye ilk gireni Login'e yolla
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Giriş yapmış kullanıcılar için senin tasarımın
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ARTIK ANA PANEL BURASI
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    
    // Ürün işlemleri
    Route::get('/urun-ekle', function () { return view('urun_ekle'); })->name('urun.ekle');
    Route::post('/urun-kaydet', [ProductController::class, 'store'])->name('urun.kaydet');
    Route::get('/urun/duzenle/{id}', [ProductController::class, 'edit'])->name('urun.duzenle');
    Route::post('/urun/guncelle/{id}', [ProductController::class, 'update'])->name('urun.guncelle');
    Route::get('/urun/sil/{id}', [ProductController::class, 'destroy'])->name('urun.sil');
    Route::get('/stok-takibi', [ProductController::class, 'stokTakibi'])->name('stok.takibi');
    Route::get('/fiyat-listesi', [ProductController::class, 'fiyatListesi'])->name('fiyat.listesi');
    Route::get('/satis-yap', [ProductController::class, 'satisYap'])->name('satis.yap');
    Route::post('/satis-kaydet', [ProductController::class, 'satisKaydet'])->name('satis.kaydet');
    Route::get('/satis-gecmisi', [ProductController::class, 'satisGecmisi'])->name('satis.gecmisi');
    Route::post('/gider-kaydet', [ProductController::class, 'giderKaydet'])->name('gider.kaydet');
    Route::get('/gider-gecmisi', [ProductController::class, 'giderGecmisi'])->name('gider.gecmisi');
    Route::get('/fatura/{sale_id}', [ProductController::class, 'faturaGoruntule'])->name('fatura.goruntule');
});

require __DIR__.'/auth.php';