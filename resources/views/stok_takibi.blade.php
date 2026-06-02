<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Stok Takibi | Burcu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f5f6fa; font-family: 'Segoe UI', sans-serif; }
        .table-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="p-5">
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h2 class="fw-bold"><i class="fas fa-boxes text-primary me-2"></i>Stok Durumu</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Geri Dön</a>
        </div>
        <div class="card table-card bg-white p-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>Ürün Adı</th><th>Mevcut Stok</th><th>Durum</th><th>İşlem</th></tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="fw-bold">{{ $product->urun_adi }}</td>
                        <td>{{ $product->stok_miktari }} Adet</td>
                        <td>
                            @if($product->stok_miktari < 10)
                                <span class="badge bg-danger">Kritik Seviye</span>
                            @else
                                <span class="badge bg-success">Stok Tamam</span>
                            @endif
                        </td>
                        <td><a href="{{ route('urun.duzenle', $product->id) }}" class="btn btn-sm btn-light border">Güncelle</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>