<?php session_start(); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Luméa - Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FCF2F4; color: #333; overflow-x: hidden; }
        .top-banner { background-color: #6F8A70; color: black; font-size: 12px; padding: 5px 0; }
        .serif-text { font-family: 'Playfair Display', serif; }
        .navbar-custom { background-color: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        
        .btn-sage { background-color: #A9C2A4; color: black; font-weight: 500; border-radius: 10px; border: none; padding: 10px 30px; transition: 0.3s;}
        .btn-sage:hover { background-color: #8fa685; }
        .cart-item { background: white; border-radius: 15px; padding: 20px; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .cart-item img { width: 80px; border-radius: 10px; margin-right: 20px;}

        /* Footer */
        footer { background-color: #1E3B27; color: white; padding: 60px 0 20px; margin-top: 80px; }
        footer a { color: #A9C2A4; text-decoration: none; transition: 0.3s; }
        footer a:hover { color: white; }
    </style>
</head>
<body>

    <div class="top-banner text-center position-relative fw-bold">Just Restocked | Shop Our Fragrance Collection</div>

    <!-- Navbar Keranjang -->
    <nav class="navbar-custom py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <a href="koleksi.php" class="text-dark text-decoration-none fw-bold">
                    <i class="bi bi-arrow-left me-2"></i>KEMBALI
                </a>
            </div>
            
            <div class="d-flex align-items-center gap-4">
                <span class="text-dark fw-bold">Halo, <?= $_SESSION['username'] ?>!
        
                <!-- Ikon Pesanan (Berubah menjadi bentuk paket pengiriman) -->
                <a href="pesanan.php" class="text-dark text-decoration-none" title="Lacak Pesanan">
                    <i class="bi bi-box-seam fs-5 align-middle"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="min-height: 50vh;">
        <h1 class="serif-text fw-bold mb-4" style="font-size: 3rem;">Keranjang Anda</h1>
        
        <div class="row">
            <!-- Area Daftar Produk di Keranjang -->
            <div class="col-md-8" id="daftarKeranjang"></div>

            <!-- Area Ringkasan Harga -->
            <div class="col-md-4">
                <div class="cart-item" style="background-color: #CFDAC8;">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Barang:</span>
                        <span id="totalBarang" class="fw-bold">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 fs-5">
                        <span>Subtotal:</span>
                        <span id="subtotalHarga" class="fw-bold">Rp. 0</span>
                    </div>
                    <a href="checkout.php" id="btnCheckout" class="btn btn-sage w-100 fw-bold">LANJUT CHECKOUT</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Super Lengkap -->
    <footer>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <h4 class="serif-text fw-bold mb-3">LUMÉA</h4>
                    <p class="small text-white-50" style="line-height: 1.8; text-align: justify;">
                        Luméa Perfume adalah merek wewangian independen yang berdedikasi untuk menciptakan aroma elegan dengan sentuhan personal. Kami percaya bahwa setiap aroma menyimpan kenangan.
                    </p>
                </div>
                <div class="col-md-2 offset-md-1 mb-4">
                    <h6 class="fw-bold mb-3 text-uppercase">Tautan Cepat</h6>
                    <ul class="list-unstyled small" style="line-height: 2;">
                        <li><a href="home.php">Beranda</a></li>
                        <li><a href="koleksi.php">Katalog Produk</a></li>
                        <li><a href="about.php">Tentang Kami</a></li>
                        <li><a href="#">Cara Pembelian</a></li>
                    </ul>
                </div>
                <div class="col-md-4 offset-md-1 mb-4">
                    <h6 class="fw-bold mb-3 text-uppercase">Bantuan & Kontak</h6>
                    <ul class="list-unstyled small text-white-50" style="line-height: 2;">
                        <li><i class="bi bi-envelope me-2"></i> hello@lumeaperfume.com</li>
                        <li><i class="bi bi-whatsapp me-2"></i> +62 812 3456 7890</li>
                        <li><a href="#">FAQ (Pertanyaan Umum)</a></li>
                        <li><a href="#">Syarat & Ketentuan Pengembalian</a></li>
                    </ul>
                    <div class="mt-3 fs-5">
                        <a href="#" class="me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-tiktok"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center small text-white-50 border-top border-secondary pt-4 mt-2">
                &copy; 2026 Luméa Perfume. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <script>

        function renderKeranjang() {
            let keranjang = JSON.parse(localStorage.getItem("keranjangLumea")) || [];
            let wadah = document.getElementById('daftarKeranjang');
            let wadahHtml = "";
            let totalQty = 0;
            let subtotal = 0;

            if(keranjang.length === 0) {
                wadah.innerHTML = "<div class='alert alert-warning text-center'>Keranjang masih kosong. Yuk belanja dulu!</div>";
                document.getElementById('btnCheckout').classList.add('disabled');
                return;
            }

            keranjang.forEach((item, index) => {
                let totalPerItem = item.harga * item.qty;
                totalQty += item.qty;
                subtotal += totalPerItem;

                wadahHtml += `
                    <div class="cart-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="${item.gambar}" alt="${item.nama}">
                            <div>
                                <h5 class="serif-text fw-bold m-0">${item.nama}</h5>
                                <p class="text-muted m-0" style="font-size: 13px;">Rp. ${item.harga.toLocaleString('id-ID')} x ${item.qty}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="fw-bold mb-2">Rp. ${totalPerItem.toLocaleString('id-ID')}</h6>
                            <button class="btn btn-sm btn-outline-danger" onclick="hapusItem(${index})"><i class="bi bi-trash"></i> Hapus</button>
                        </div>
                    </div>
                `;
            });

            wadah.innerHTML = wadahHtml;
            document.getElementById('totalBarang').innerText = totalQty;
            document.getElementById('subtotalHarga').innerText = "Rp. " + subtotal.toLocaleString('id-ID');
        }

        function hapusItem(indeks) {
            let keranjang = JSON.parse(localStorage.getItem("keranjangLumea")) || [];
            keranjang.splice(indeks, 1);
            localStorage.setItem("keranjangLumea", JSON.stringify(keranjang));
            renderKeranjang(); 
        }

        renderKeranjang();
    </script>
</body>
</html>