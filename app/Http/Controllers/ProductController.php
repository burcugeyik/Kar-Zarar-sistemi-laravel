<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{

    public function index()
    {
        $sermayeSetting = \App\Models\Setting::where('key', 'sermaye')->first();
        $sermaye = $sermayeSetting ? $sermayeSetting->value : 0;

        $products = Product::all();
        $sales = \App\Models\Sale::all();
        
        // 1. ADIM: Masrafları topla
        $toplamMasraf = \App\Models\Expense::sum('tutar');

        $toplamGider = $products->sum(function($product) {
            return $product->alis_fiyati * $product->stok_miktari;
        });

        $toplamGelir = $sales->sum('toplam_tutar');
        
        // 2. ADIM: Kasa hesabından masrafları da düş
        $kasaDurumu = $sermaye - $toplamGider + $toplamGelir - $toplamMasraf;
        
        $toplamKar = $sales->sum('elde_edilen_kar');
        $kritikStok = $products->where('stok_miktari', '<', 10)->count();
        
        // 3. ADIM: Kritik ürün listesini return'den önceye çekelim
        $kritikUrunler = Product::where('stok_miktari', '<', 10)->get();

        // --- GRAFİK VERİSİ ---
        $grafikEtiketler = [];
        $grafikVeri = [];
        for ($i = 6; $i >= 0; $i--) {
            $tarih = \Carbon\Carbon::now()->subDays($i);
            $grafikEtiketler[] = $tarih->format('d M');
            $gunlukSatis = \App\Models\Sale::whereDate('created_at', $tarih)->sum('toplam_tutar');
            $grafikVeri[] = $gunlukSatis;
        }

        // 4. ADIM: Compact içine yeni değişkenleri ekle
        return view('dashboard', compact(
            'products', 'toplamKar', 'kasaDurumu', 'toplamGelir', 
            'toplamGider', 'kritikStok', 'grafikEtiketler', 'grafikVeri', 
            'toplamMasraf', 'kritikUrunler'
        ));
    }

    // Yeni Ürün Kaydetme
    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect('/')->with('success', 'Ürün başarıyla eklendi!');
    }

    // Düzenleme Sayfası
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('urun_duzenle', compact('product'));
    }

    // Güncelleme İşlemi
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect('/')->with('success', 'Ürün güncellendi!');
    }

    // Silme İşlemi
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect('/')->with('success', 'Ürün silindi!');
    }

    // Stok Takibi Sayfası
    public function stokTakibi()
    {
        $products = Product::orderBy('stok_miktari', 'asc')->get();
        return view('stok_takibi', compact('products'));
    }

    // Fiyat Listesi Sayfası
    public function fiyatListesi()
    {
        $products = Product::all();
        return view('fiyat_listesi', compact('products'));
    }

    public function satisYap()
    {
        $products = Product::all();
        return view('satis_yap', compact('products'));
    }

    public function satisKaydet(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        // 1. Stok kontrolü
        if ($product->stok_miktari < $request->stok_miktari) {
            return back()->with('error', 'Yeterli stok yok!');
        }

        // 2. Kârı hesapla
        $kar = ($request->satis_fiyati - $request->alis_fiyati) * $request->stok_miktari;

        // 3. Satışı kaydet
        \App\Models\Sale::create([
            'product_id' => $product->id,
            'adet' => $request->stok_miktari,
            'satis_fiyati' => $request->satis_fiyati,
            'toplam_tutar' => $request->satis_fiyati * $request->stok_miktari,
            'elde_edilen_kar' => $kar
        ]);

        // 4. Stoktan düş
        $product->decrement('stok_miktari', $request->stok_miktari);

        return redirect()->route('dashboard')->with('success', 'Satış başarıyla tamamlandı!');
    }

    public function satisGecmisi(Request $request)
    {
        $query = \App\Models\Sale::with('product')->orderBy('created_at', 'desc');

        // Tarih Filtreleme Mantığı
        if ($request->filter == 'gun') {
            $query->whereDate('created_at', \Carbon\Carbon::today());
        } elseif ($request->filter == 'hafta') {
            $query->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
        } elseif ($request->filter == 'ay') {
            $query->whereMonth('created_at', \Carbon\Carbon::now()->month);
        } elseif ($request->filter == 'yil') {
            $query->whereYear('created_at', \Carbon\Carbon::now()->year);
        }

        $sales = $query->get();
        
        // Toplam istatistikler
        $toplamSatis = $sales->sum('toplam_tutar');
        $toplamKar = $sales->sum('elde_edilen_kar');

        return view('satis_gecmisi', compact('sales', 'toplamSatis', 'toplamKar'));
    }

    public function giderKaydet(Request $request)
    {
        // Formdan gelen bilgileri masraf tablosuna kaydet
        \App\Models\Expense::create([
            'baslik'   => $request->baslik,
            'tutar'    => $request->tutar,
            'kategori' => $request->kategori,
        ]);

        // Kayıt bittikten sonra başarı mesajıyla geri dön
        return redirect()->back()->with('success', 'Masraf başarıyla kaydedildi.');
    }

    public function giderGecmisi()
{
    // Tüm giderleri en yeniden en eskiye doğru çekiyoruz
    $expenses = \App\Models\Expense::orderBy('created_at', 'desc')->get();
    $toplamGider = $expenses->sum('tutar');

    return view('gider_gecmisi', compact('expenses', 'toplamGider'));
}

public function faturaGoruntule($sale_id)
{
    // Satış verisini ve ilgili ürün bilgilerini çekiyoruz
    $sale = \App\Models\Sale::with('product')->findOrFail($sale_id);
    
    return view('fatura', compact('sale'));
}

}