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
    <title>Luméa - Beranda Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FCF2F4; color: #333; overflow-x: hidden; }
        .top-banner { background-color: #6F8A70; color: black; font-size: 12px; padding: 5px 0; }
        .serif-text { font-family: 'Playfair Display', serif; }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('uploads/<?= $data_toko['link_banner'] ?>') no-repeat center center/cover;
            height: 85vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        
        .btn-sage { background-color: #A9C2A4; color: black; font-weight: 500; border-radius: 30px; border: none; padding: 12px 40px; transition: 0.3s; }
        .btn-sage:hover { background-color: #8fa685; }
        
        footer { background-color: #1E3B27; color: white; padding: 60px 0 20px; }
        footer a { color: #A9C2A4; text-decoration: none; transition: 0.3s; }
        footer a:hover { color: white; }
    </style>
</head>
<body>

    <div class="top-banner text-center fw-bold">Just Restocked | Shop Our Fragrance Collection</div>

    <!-- Navbar yang Sudah Dirapikan -->
    <nav class="navbar navbar-expand-lg bg-transparent position-absolute w-100 z-3 mt-3">
        <div class="container d-flex justify-content-between align-items-center">
            
            <!-- Kiri (Hanya About Us) -->
            <div class="d-flex align-items-center">
                <a href="about.php" class="text-white text-decoration-none fw-bold" style="text-shadow: 1px 1px 3px black;">ABOUT US</a>
            </div>

            <!-- Kanan (Nama, Keranjang, Pesanan) -->
            <div class="d-flex align-items-center gap-4">
                <span class="text-white fw-bold" style="text-shadow: 1px 1px 3px black;">Halo, <?= $_SESSION['username'] ?>!</span>
                <a href="keranjang.php" class="text-white text-decoration-none" title="Keranjang" style="text-shadow: 1px 1px 3px black;"><i class="bi bi-bag fs-5 align-middle"></i></a>
                <a href="pesanan.php" class="text-white text-decoration-none" title="Pesanan Saya" style="text-shadow: 1px 1px 3px black;"><i class="bi bi-box-seam fs-5 align-middle"></i></a>
            </div>
            
        </div>
    </nav>

    <!-- Banner Utama (Hero Section) -->
    <div class="hero-section">
        <div>
            <h1 class="serif-text fw-bold mb-3" style="font-size: 5rem; letter-spacing: 2px;">LUMÉA PERFUME</h1>
            <h4 class="serif-text fst-italic mb-5" style="font-weight: 300;">Elevate everyday moments to extraordinary.</h4>
            <a href="koleksi.php" class="btn btn-sage fs-6 fw-bold text-decoration-none">DISCOVER THE COLLECTION</a>
        </div>
    </div>

    <!-- Section: Penjelasan Singkat (Nilai Jual) -->
    <div class="container my-5 py-5 text-center">
        <h2 class="serif-text fw-bold mb-4" style="color: #1E3B27;">Why Choose Luméa?</h2>
        <p class="text-muted mb-5 w-75 mx-auto">Kami menghadirkan esensi kemewahan dalam setiap botol. Dibuat dengan bahan-bahan premium yang tahan lama, Luméa dirancang untuk menyesuaikan dengan kepribadian unik Anda.</p>
        
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <i class="bi bi-droplet-half fs-1" style="color: #A9C2A4;"></i>
                <h5 class="fw-bold mt-3" style="color: #1E3B27;">Premium Essence</h5>
                <p class="small text-muted">Bahan alami berkualitas tinggi yang diimpor langsung dari Eropa.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-clock-history fs-1" style="color: #A9C2A4;"></i>
                <h5 class="fw-bold mt-3" style="color: #1E3B27;">Long Lasting</h5>
                <p class="small text-muted">Formula Extrait de Parfum dengan ketahanan wangi hingga 12 jam.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-box2-heart fs-1" style="color: #A9C2A4;"></i>
                <h5 class="fw-bold mt-3" style="color: #1E3B27;">Eco-Friendly</h5>
                <p class="small text-muted">Kemasan kaca yang dapat didaur ulang dan ramah lingkungan.</p>
            </div>
        </div>
    </div>

    <!-- Footer Dinamis -->
    <footer>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <h4 class="serif-text fw-bold mb-3">LUMÉA</h4>
                    <p class="small text-white-50" style="line-height: 1.8; text-align: justify;">
                        <?= $data_toko['deskripsi_footer'] ?>
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
                        <li><i class="bi bi-envelope me-2"></i> <?= $data_toko['email_toko'] ?></li>
                        <li><i class="bi bi-whatsapp me-2"></i> <?= $data_toko['telepon_toko'] ?></li>
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
</body>
</html>