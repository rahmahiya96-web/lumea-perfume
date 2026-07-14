<?php
session_start();
include 'koneksi.php';
$query_toko = mysqli_query($conn, "SELECT * FROM konfigurasi_toko WHERE id=1");
$data_toko = mysqli_fetch_array($query_toko);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Luméa - About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FCF2F4; color: #333; }
        .serif-text { font-family: 'Playfair Display', serif; }
        
        footer { background-color: #1E3B27; color: white; padding: 60px 0 20px; }
        footer a { color: #A9C2A4; text-decoration: none; transition: 0.3s; }
        footer a:hover { color: white; }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5 d-flex justify-content-between align-items-center border-bottom pb-3">
        <h3 class="serif-text fw-bold m-0" style="color: #1E3B27;">LUMÉA</h3>
        <a href="home.php" class="text-dark text-decoration-none fw-bold" style="font-size: 14px;">KEMBALI KE BERANDA</a>
    </div>

    <div class="container mb-5">
        <div class="row align-items-center">
            <div class="col-md-5">
                <img src="bglg-mawar.png" alt="About Lumea" class="img-fluid rounded-4 shadow">
            </div>
            <div class="col-md-6 offset-md-1">
                <h1 class="serif-text fw-bold mb-4" style="color: #1E3B27; font-size: 3.5rem;">Cerita Kami</h1>
                <p class="text-muted" style="line-height: 1.9; text-align: justify;">
                    Berawal dari kecintaan terhadap seni meracik aroma, Luméa lahir dengan satu visi: memberikan sentuhan percaya diri melalui wewangian yang merepresentasikan karakter Anda. Kami percaya bahwa parfum bukan hanya sekadar pelengkap, melainkan identitas yang tertinggal di udara bahkan setelah Anda pergi.
                </p>
                <p class="text-muted" style="line-height: 1.9; text-align: justify;">
                    Setiap varian Luméa diracik secara teliti oleh para ahli menggunakan bahan baku bersertifikat IFRA (International Fragrance Association), memastikan keamanannya untuk kulit sekaligus kelestarian alam.
                </p>
                <h5 class="serif-text fw-bold mt-5" style="color: #1E3B27;">Luméa Team</h5>
            </div>
        </div>
    </div>

    <!-- Footer Dinamis -->
    <footer style="background-color: #1E3B27; color: white; padding: 60px 0 20px; margin-top: 80px;">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <h4 class="fw-bold mb-3" style="font-family: 'Playfair Display', serif;">LUMÉA</h4>
                    <p class="small text-white-50" style="line-height: 1.8; text-align: justify;">
                        <?= $data_toko['deskripsi_footer'] ?>
                    </p>
                </div>
                <div class="col-md-2 offset-md-1 mb-4">
                    <h6 class="fw-bold mb-3 text-uppercase">Tautan Cepat</h6>
                    <ul class="list-unstyled small" style="line-height: 2;">
                        <li><a href="home.php" style="color: #A9C2A4; text-decoration: none;">Beranda</a></li>
                        <li><a href="koleksi.php" style="color: #A9C2A4; text-decoration: none;">Katalog Produk</a></li>
                        <li><a href="about.php" style="color: #A9C2A4; text-decoration: none;">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="col-md-4 offset-md-1 mb-4">
                    <h6 class="fw-bold mb-3 text-uppercase">Bantuan & Kontak</h6>
                    <ul class="list-unstyled small text-white-50" style="line-height: 2;">
                        <li><i class="bi bi-envelope me-2"></i> <?= $data_toko['email_toko'] ?></li>
                        <li><i class="bi bi-whatsapp me-2"></i> <?= $data_toko['telepon_toko'] ?></li>
                    </ul>
                </div>
            </div>
            <div class="text-center small text-white-50 border-top border-secondary pt-4 mt-2">
                &copy; 2026 Luméa Perfume. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>
</body>
</html>