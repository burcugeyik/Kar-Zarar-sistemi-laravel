<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container bg-white p-4 shadow rounded" style="max-width: 600px;">
        <h2 class="mb-4">✏️ Ürün Bilgilerini Güncelle</h2>
        
        <form action="{{ route('urun.guncelle', $product->id) }}" method="POST">
            @csrf 
            <div class="mb-3">
                <label class="form-label fw-bold">Ürün Adı:</label>
                <input type="text" name="urun_adi" class="form-control" value="{{ $product->urun_adi }}" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Alış Fiyatı:</label>
                    <input type="number" step="0.01" name="alis_fiyati" class="form-control" value="{{ $product->alis_fiyati }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Satış Fiyatı:</label>
                    <input type="number" step="0.01" name="satis_fiyati" class="form-control" value="{{ $product->satis_fiyati }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kargo Ücreti:</label>
                    <input type="number" step="0.01" name="kargo_ucreti" class="form-control" value="{{ $product->kargo_ucreti }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">KDV Oranı (%):</label>
                    <input type="number" name="kdv_orani" class="form-control" value="{{ $product->kdv_orani }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Stok Miktarı:</label>
                <input type="number" name="stok_miktari" class="form-control" value="{{ $product->stok_miktari }}" required>
            </div>
            <button type="submit" class="btn btn-warning w-100 py-2 fw-bold">Değişiklikleri Kaydet</button>
            <a href="{{ url('/') }}" class="btn btn-link w-100 mt-2 text-muted">İptal Et</a>
        </form>
    </div>
</body>
</html>