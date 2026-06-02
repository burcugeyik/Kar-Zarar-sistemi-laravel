<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satış Yap | Burcu Finans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #1e1e2d; --main-bg: #f5f6fa; }
        body { background-color: var(--main-bg); font-family: 'Segoe UI', sans-serif; }
        .sales-card { 
            border: none; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            max-width: 600px; 
            margin: 80px auto; 
            background: white;
            padding: 40px;
        }
        .form-control, .form-select { 
            border-radius: 12px; 
            padding: 12px; 
            border: 1px solid #e0e0e0; 
            margin-bottom: 20px;
        }
        .btn-sales { 
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%); 
            border: none; 
            border-radius: 12px; 
            padding: 15px; 
            font-weight: bold; 
            color: white;
            transition: 0.3s;
        }
        .btn-sales:hover { opacity: 0.9; transform: translateY(-2px); }
        .price-display { background-color: #f8f9fa; border-radius: 12px; padding: 15px; border: 1px dashed #dee2e6; }
    </style>
</head>
<body>

    <div class="container">
        <div class="sales-card">
            <div class="text-center mb-4">
                <div class="h1 text-primary"><i class="fas fa-cart-arrow-down"></i></div>
                <h3 class="fw-bold">Yeni Satış Kaydı</h3>
                <p class="text-muted">Lütfen sattığınız ürünü seçin.</p>
            </div>

            <form action="{{ route('satis.kaydet') }}" method="POST">
                @csrf
                
                <label class="form-label fw-bold small">1. Ürün Seçimi</label>
                <select name="product_id" id="product_select" class="form-select" required onchange="fiyatlariGuncelle()">
                    <option value="" disabled selected>Satılan Ürünü Seçin...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" 
                                data-alis="{{ $product->alis_fiyati }}" 
                                data-satis="{{ $product->satis_fiyati }}"
                                data-stok="{{ $product->stok_miktari }}">
                            {{ $product->urun_adi }} (Mevcut Stok: {{ $product->stok_miktari }})
                        </option>
                    @endforeach
                </select>

                <div class="price-display mb-4">
                    <div class="row text-center">
                        <div class="col-6">
                            <small class="text-muted d-block">Birim Alış</small>
                            <span id="label_alis" class="fw-bold text-danger">0.00 TL</span>
                            <input type="hidden" name="alis_fiyati" id="input_alis">
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Birim Satış</small>
                            <span id="label_satis" class="fw-bold text-success">0.00 TL</span>
                            <input type="hidden" name="satis_fiyati" id="input_satis">
                        </div>
                    </div>
                </div>

                <label class="form-label fw-bold small">2. Satış Adedi</label>
                <input type="number" name="stok_miktari" id="satis_adedi" class="form-control" placeholder="Kaç adet satıldı?" required min="1">

                <button type="submit" class="btn btn-sales w-100 shadow mt-3">
                    <i class="fas fa-check-circle me-2"></i> Satışı Onayla ve Kasaya İşle
                </button>
                
                <div class="text-center mt-4">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted small">
                        <i class="fas fa-arrow-left me-1"></i> Vazgeç, Panele Dön
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function fiyatlariGuncelle() {
            const select = document.getElementById('product_select');
            const selectedOption = select.options[select.selectedIndex];
            
            // Verileri al
            const alis = selectedOption.getAttribute('data-alis');
            const satis = selectedOption.getAttribute('data-satis');
            const stok = selectedOption.getAttribute('data-stok');
            
            // Etiketleri güncelle (Görsel)
            document.getElementById('label_alis').innerText = alis + " TL";
            document.getElementById('label_satis').innerText = satis + " TL";
            
            // Gizli inputları güncelle (Veritabanı için)
            document.getElementById('input_alis').value = alis;
            document.getElementById('input_satis').value = satis;
            
            // Max stok sınırını belirle
            document.getElementById('satis_adedi').max = stok;
        }
    </script>

</body>
</html>