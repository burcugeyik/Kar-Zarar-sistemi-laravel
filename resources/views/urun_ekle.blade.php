<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Ürün Ekle | Burcu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f5f6fa; font-family: 'Segoe UI', sans-serif; }
        .form-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn-back { border-radius: 10px; transition: 0.3s; }
        .btn-save { border-radius: 12px; padding: 12px; font-weight: 600; }
    </style>
</head>
<body class="p-5">
    <div class="container" style="max-width: 700px;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0"><i class="fas fa-plus-circle text-primary me-2"></i>Yeni Ürün Ekle</h2>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-back">
                <i class="fas fa-arrow-left me-2"></i>Geri Dön
            </a>
        </div>
        
        <div class="card form-card p-4 bg-white">
            <form action="{{ route('urun.kaydet') }}" method="POST">
                @csrf 
                <div class="mb-4">
                    <label class="form-label fw-bold text-muted small">ÜRÜN ADI</label>
                    <input type="text" name="urun_adi" class="form-control form-control-lg border-0 bg-light" placeholder="Örn: Kablosuz Klavye" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-muted small">ALIŞ FİYATI (TL)</label>
                        <input type="number" step="0.01" name="alis_fiyati" class="form-control border-0 bg-light" placeholder="0.00" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-muted small">SATIŞ FİYATI (TL)</label>
                        <input type="number" step="0.01" name="satis_fiyati" class="form-control border-0 bg-light" placeholder="0.00" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-muted small">KARGO ÜCRETİ (TL)</label>
                        <input type="number" step="0.01" name="kargo_ucreti" class="form-control border-0 bg-light" value="0.00">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-muted small">KDV ORANI (%)</label>
                        <input type="number" name="kdv_orani" class="form-control border-0 bg-light" value="20">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-muted small">STOK MİKTARI</label>
                    <input type="number" name="stok_miktari" class="form-control border-0 bg-light" placeholder="0" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-save shadow">
                    <i class="fas fa-check-circle me-2"></i>Ürünü Sisteme Kaydet
                </button>
            </form>
        </div>
    </div>
</body>
</html>