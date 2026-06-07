<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burcu Finans Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --sidebar-bg: #1e1e2d; --main-bg: #f5f6fa; }
        body { background-color: var(--main-bg); font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        .sidebar { width: 250px; height: 100vh; background: var(--sidebar-bg); position: fixed; color: white; padding-top: 20px; z-index: 1000; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 800; padding: 20px; text-align: center; color: #00d2ff; border-bottom: 1px solid #2b2b40; }
        .nav-link { color: #a2a3b7; padding: 15px 25px; font-weight: 500; border: none; background: transparent; width: 100%; text-align: left; }
        .nav-link:hover, .nav-link.active { color: white; background: #2b2b40; border-left: 4px solid #00d2ff; }
        .nav-link i { margin-right: 10px; width: 20px; }
        .main-content { margin-left: 250px; padding: 40px; }
        .stat-card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .card-icon { width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .table-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .bg-gradient-custom { background: linear-gradient(135deg, #1e1e2d 0%, #33334d 100%); color: white; }
        .user-info { padding: 15px 25px; font-size: 0.85rem; color: #00d2ff; border-bottom: 1px solid #2b2b40; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">BURCU ADMIN</div>
        <div class="user-info">
            <i class="fas fa-user-circle me-2"></i> {{ Auth::user()->name }}
        </div>
        <nav class="nav flex-column mt-2">
            <a class="nav-link active" href="{{ route('dashboard') }}"><i class="fas fa-chart-pie"></i> Panel</a>
            <a class="nav-link" href="{{ route('urun.ekle') }}"><i class="fas fa-plus-square"></i> Ürün Ekle</a>
            <a class="nav-link" href="{{ route('stok.takibi') }}"><i class="fas fa-boxes"></i> Stok Takibi</a>
            <a class="nav-link" href="{{ route('fiyat.listesi') }}"><i class="fas fa-tags"></i> Fiyat Listesi</a>
            <a class="nav-link" href="{{ route('gider.gecmisi') }}"><i class="fas fa-file-invoice-dollar"></i> Gider Geçmişi</a>
            <a class="nav-link" href="{{ route('satis.gecmisi') }}"><i class="fas fa-history"></i> Satış Geçmişi</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-5">
                @csrf
                <button type="submit" class="nav-link text-danger border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold m-0">Finans Paneli</h2>
            <span class="badge bg-white text-dark shadow-sm p-2">{{ date('d.m.Y') }}</span>
        </div>

        {{-- 1. EKLENTİ: KRİTİK STOK LİSTESİ (İSİM BAZLI) --}}
        @if($kritikUrunler->count() > 0)
        <div class="alert alert-warning border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3 text-warning fs-4"></i>
                <div>
                    <strong>Kritik Stok Uyarısı:</strong> 
                    @foreach($kritikUrunler as $urun)
                        {{ $urun->urun_adi }} ({{ $urun->stok_miktari }} adet)@if(!$loop->last), @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card stat-card p-3 bg-white">
                    <div class="d-flex justify-content-between">
                        <div><h6 class="text-muted small mb-1">Güncel Kasa (Nakit)</h6><h4 class="fw-bold m-0 text-primary">{{ number_format($kasaDurumu, 2) }} TL</h4></div>
                        <div class="card-icon bg-primary-subtle text-primary"><i class="fas fa-wallet"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 bg-white">
                    <div class="d-flex justify-content-between">
                        <div><h6 class="text-muted small mb-1">Toplam Satış Geliri</h6><h4 class="fw-bold m-0 text-success">{{ number_format($toplamGelir, 2) }} TL</h4></div>
                        <div class="card-icon bg-success-subtle text-success"><i class="fas fa-hand-holding-usd"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 bg-white">
                    <div class="d-flex justify-content-between">
                        <div><h6 class="text-muted small mb-1">Toplam Mal Alımı</h6><h4 class="fw-bold m-0 text-warning">{{ number_format($toplamGider, 2) }} TL</h4></div>
                        <div class="card-icon bg-warning-subtle text-warning"><i class="fas fa-shopping-cart"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 bg-white">
                    <div class="d-flex justify-content-between">
                        <div><h6 class="text-muted small mb-1">Kritik Stok</h6><h4 class="fw-bold m-0 text-danger">{{ $kritikStok }} Ürün</h4></div>
                        <div class="card-icon bg-danger-subtle text-danger"><i class="fas fa-exclamation-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. EKLENTİ: HIZLI MASRAF GİRİŞ FORMU --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-minus-circle text-danger me-2"></i>Hızlı Masraf Gir</h5>
                <form action="{{ route('gider.kaydet') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" name="baslik" class="form-control" placeholder="Masraf Başlığı (Örn: Kira)" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="tutar" class="form-control" placeholder="Tutar (TL)" required>
                    </div>
                    <div class="col-md-3">
                        <select name="kategori" class="form-control">
                            <option value="Fatura">Fatura</option>
                            <option value="Kira">Kira</option>
                            <option value="Personel">Personel</option>
                            <option value="Diger">Diğer</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger w-100 text-white">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card table-card p-4 bg-white mb-4">
                    <h5 class="fw-bold mb-4">Finansal Analiz</h5>
                    <canvas id="karChart" height="120"></canvas>
                </div>

                {{-- 3. EKLENTİ: SON HARCAMALAR TABLOSU --}}
                <div class="card table-card bg-white p-0 mb-4">
                    <div class="p-4"><h5 class="fw-bold m-0 text-danger">Son Harcamalar 💸</h5></div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th class="ps-4">Tarih</th><th>Açıklama</th><th>Kategori</th><th>Tutar</th></tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Expense::where('user_id', auth()->id())->latest()->take(5)->get() as $gider)
                                <tr>
                                    <td class="ps-4">{{ $gider->created_at->format('d.m.Y') }}</td>
                                    <td>{{ $gider->baslik }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $gider->kategori }}</span></td>
                                    <td class="text-danger fw-bold">-{{ number_format($gider->tutar, 2) }} TL</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card table-card bg-white p-0">
                    <div class="p-4"><h5 class="fw-bold m-0">Envanterdeki Ürünler</h5></div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th class="ps-4">Ürün</th><th>Alış Maliyeti</th><th>Stok</th><th class="text-center">İşlem</th></tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $product->urun_adi }}</td>
                                    <td>{{ number_format($product->alis_fiyati, 2) }} TL</td>
                                    <td><span class="badge {{ $product->stok_miktari < 10 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">{{ $product->stok_miktari }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('urun.duzenle', $product->id) }}" class="btn btn-sm btn-light border"><i class="fas fa-pen"></i></a>
                                        <a href="{{ route('urun.sil', $product->id) }}" class="btn btn-sm btn-light border" onclick="return confirm('Silinsin mi?')"><i class="fas fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card table-card p-4 bg-gradient-custom text-white shadow-lg mb-4">
                    <h6 class="opacity-75">Ekstra Masraflar Toplamı</h6>
                    <h2 class="fw-bold">{{ number_format($toplamMasraf, 2) }} TL</h2>
                    <hr class="opacity-25">
                    <p class="small opacity-75">Kira, fatura ve diğer tüm ek giderlerin toplamıdır.</p>
                </div>

                <div class="card table-card p-4 bg-success text-white shadow-lg">
                    <h6 class="opacity-75">Toplam Net Kâr (Satışlardan)</h6>
                    <h2 class="fw-bold display-6">{{ number_format($toplamKar, 2) }} TL</h2>
                    <hr class="opacity-25">
                    <p class="small opacity-75">Bu kâr sadece satılan ürünlerin maliyeti üzerinden hesaplanmıştır.</p>
                    <a href="{{ route('satis.yap') }}" class="btn btn-white bg-white text-success fw-bold w-100 shadow">Hemen Satış Yap</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    const ctx = document.getElementById('karChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($grafikEtiketler),
            datasets: [{
                label: 'Günlük Ciro (TL)',
                data: @json($grafikVeri),
                borderColor: '#00d2ff',
                backgroundColor: 'rgba(0, 210, 255, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#00d2ff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
</body>
</html>