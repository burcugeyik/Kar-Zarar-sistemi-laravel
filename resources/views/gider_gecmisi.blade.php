<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gider Geçmişi - Burcu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f5f6fa; font-family: 'Segoe UI', sans-serif; }
        .main-content { padding: 40px; }
        .table-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); background: white; }
    </style>
</head>
<body>
    <div class="main-content container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><i class="fas fa-history text-danger me-2"></i>Tüm Gider Geçmişi</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-dark shadow-sm"><i class="fas fa-arrow-left me-2"></i>Panele Dön</a>
        </div>

        <div class="card table-card p-4 mb-4 bg-danger text-white">
            <h6 class="opacity-75">Toplam Harcama Tutarı</h6>
            <h2 class="fw-bold m-0">{{ number_format($toplamGider, 2) }} TL</h2>
        </div>

        <div class="card table-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tarih</th>
                            <th>Harcama Başlığı</th>
                            <th>Kategori</th>
                            <th class="text-end pe-4">Tutar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td class="ps-4 text-muted">{{ $expense->created_at->format('d.m.Y H:i') }}</td>
                            <td class="fw-bold">{{ $expense->baslik }}</td>
                            <td><span class="badge bg-light text-dark">{{ $expense->kategori }}</span></td>
                            <td class="text-end pe-4 text-danger fw-bold">-{{ number_format($expense->tutar, 2) }} TL</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-5 text-muted">Henüz bir harcama kaydı bulunmuyor.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>