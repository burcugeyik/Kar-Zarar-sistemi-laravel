<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satış Geçmişi - Burcu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #1e1e2d; --main-bg: #f5f6fa; }
        body { background-color: var(--main-bg); font-family: 'Segoe UI', sans-serif; }
        .main-content { padding: 40px; }
        .table-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); background: white; }
        .filter-btn { border-radius: 10px; transition: all 0.3s; }
        .filter-btn:hover { transform: translateY(-2px); }
    </style>
</head>
<body>

    <div class="container-fluid main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold m-0"><i class="fas fa-history text-primary me-2"></i>Satış Geçmişi</h2>
                <p class="text-muted">Yapılan tüm satışların detaylı dökümü</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-dark shadow-sm px-4 filter-btn">
                <i class="fas fa-arrow-left me-2"></i>Panele Dön
            </a>
        </div>

        <!-- İstatistik Kartları -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card table-card p-4 bg-primary text-white">
                    <h6 class="opacity-75">Filtrelenen Toplam Ciro</h6>
                    <h2 class="fw-bold m-0">{{ number_format($toplamSatis, 2) }} TL</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card table-card p-4 bg-success text-white">
                    <h6 class="opacity-75">Filtrelenen Toplam Kâr</h6>
                    <h2 class="fw-bold m-0">{{ number_format($toplamKar, 2) }} TL</h2>
                </div>
            </div>
        </div>

        <!-- Filtreleme Menüsü -->
        <div class="card table-card p-3 mb-4">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('satis.gecmisi') }}" class="btn btn-outline-secondary filter-btn btn-sm px-3">Tümü</a>
                <a href="{{ route('satis.gecmisi', ['filter' => 'gun']) }}" class="btn btn-outline-primary filter-btn btn-sm px-3">Bugün</a>
                <a href="{{ route('satis.gecmisi', ['filter' => 'hafta']) }}" class="btn btn-outline-primary filter-btn btn-sm px-3">Bu Hafta</a>
                <a href="{{ route('satis.gecmisi', ['filter' => 'ay']) }}" class="btn btn-outline-primary filter-btn btn-sm px-3">Bu Ay</a>
                <a href="{{ route('satis.gecmisi', ['filter' => 'yil']) }}" class="btn btn-outline-primary filter-btn btn-sm px-3">Bu Yıl</a>
            </div>
        </div>

        <!-- Satış Tablosu -->
        <div class="card table-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tarih / Saat</th>
                            <th>Ürün Adı</th>
                            <th class="text-center">Adet</th>
                            <th>Toplam Tutar</th>
                            <th>Elde Edilen Kâr</th>
                            <th class="text-center">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-4">
                                <div class="small fw-bold">{{ $sale->created_at->format('d.m.Y') }}</div>
                                <div class="text-muted smaller">{{ $sale->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $sale->product->urun_adi ?? 'Silinmiş Ürün' }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">{{ $sale->adet }} Adet</span>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">{{ number_format($sale->toplam_tutar, 2) }} TL</span>
                            </td>
                            <td>
                                <span class="fw-bold text-success">+{{ number_format($sale->elde_edilen_kar, 2) }} TL</span>
                            </td>
                            <td class="text-center">
                                {{-- FATURA BUTONU BURADA --}}
                                <a href="{{ route('fatura.goruntule', $sale->id) }}" class="btn btn-sm btn-info text-white filter-btn" target="_blank">
                                    <i class="fas fa-file-invoice me-1"></i> Fatura
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center p-5 text-muted">
                                <i class="fas fa-search-minus mb-3 fs-1 d-block"></i>
                                Bu filtreye uygun satış kaydı bulunamadı.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>