<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Fatura #{{ $sale->id }} - Burcu Geyik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .invoice-box { max-width: 800px; margin: 30px auto; padding: 30px; background: white; border-radius: 10px; shadow: 0 0 10px rgba(0,0,0,0.1); }
        .invoice-header { border-bottom: 2px solid #00d2ff; padding-bottom: 20px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="invoice-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-primary m-0">BURCU GEYİK</h2>
                <p class="text-muted mb-0">Bilgisayar Programcılığı Projesi</p>
            </div>
            <div class="text-end">
                <h4 class="m-0">FATURA</h4>
                <p class="mb-0 text-muted">No: #{{ $sale->id }}</p>
                <p class="mb-0 text-muted">Tarih: {{ $sale->created_at->format('d.m.Y') }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <h6 class="text-muted small uppercase">Müşteri Bilgisi</h6>
                <p class="fw-bold mb-0">Genel Müşteri</p>
            </div>
        </div>

        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Ürün Adı</th>
                    <th class="text-center">Adet</th>
                    <th class="text-end">Birim Fiyat</th>
                    <th class="text-end">Toplam</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sale->product->urun_adi }}</td>
                    <td class="text-center">{{ $sale->adet }}</td>
                    <td class="text-end">{{ number_format($sale->satis_fiyati, 2) }} TL</td>
                    <td class="text-end fw-bold">{{ number_format($sale->toplam_tutar, 2) }} TL</td>
                </tr>
            </tbody>
        </table>

        <div class="row justify-content-end mt-4">
            <div class="col-4">
                <div class="d-flex justify-content-between border-top pt-2">
                    <span class="fw-bold">GENEL TOPLAM:</span>
                    <span class="fw-bold text-primary">{{ number_format($sale->toplam_tutar, 2) }} TL</span>
                </div>
            </div>
        </div>

        <div class="mt-5 text-center text-muted small">
            <p>Bu fatura otomatik olarak oluşturulmuştur. Çıktı almak için CTRL+P kullanabilirsiniz.</p>
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm d-print-none">
                <i class="fas fa-print me-2"></i>Yazdır
            </button>
        </div>
    </div>
</body>
</html>