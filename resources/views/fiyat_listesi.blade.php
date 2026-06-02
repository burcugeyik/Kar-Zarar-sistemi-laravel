<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Fiyat Listesi | Burcu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f5f6fa; font-family: 'Segoe UI', sans-serif; }
        .table-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn-edit { border-radius: 8px; transition: 0.3s; }
        .btn-edit:hover { background-color: #ffc107; color: white; border-color: #ffc107; }
    </style>
</head>
<body class="p-5">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0"><i class="fas fa-tags text-success me-2"></i>Alış - Satış Fiyatları</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Geri Dön
            </a>
        </div>

        <div class="card table-card bg-white p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Ürün Adı</th>
                            <th>Alış Fiyatı</th>
                            <th>Satış Fiyatı</th>
                            <th>Net Kar (Birim)</th>
                            <th class="text-center">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $product->urun_adi }}</td>
                            <td class="text-muted">{{ number_format($product->alis_fiyati, 2) }} TL</td>
                            <td class="fw-bold">{{ number_format($product->satis_fiyati, 2) }} TL</td>
                            <td>
                                <span class="fw-bold {{ $product->net_kar > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($product->net_kar, 2) }} TL
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('urun.duzenle', $product->id) }}" class="btn btn-sm btn-outline-warning btn-edit">
                                    <i class="fas fa-edit me-1"></i> Fiyatı Güncelle
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4 text-muted small">
            <i class="fas fa-info-circle me-1"></i> Fiyat güncellemeleri anlık olarak tüm kar tablolarını ve grafikleri etkiler.
        </div>
    </div>
</body>
</html>