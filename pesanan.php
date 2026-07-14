<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Luméa - Pesanan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FCF2F4; color: #333; overflow-x: hidden; }
        .top-banner { background-color: #6F8A70; color: black; font-size: 12px; padding: 5px 0; }
        .serif-text { font-family: 'Playfair Display', serif; }
        .navbar-custom { background-color: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        
        .order-card { background: white; border-radius: 15px; padding: 25px; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #A9C2A4; }
        .status-badge { color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .item-list { background-color: #f8f9fa; padding: 15px; border-radius: 10px; margin-top: 15px; }
        /* Footer */
        footer { background-color: #1E3B27; color: white; padding: 60px 0 20px; margin-top: 80px; }
        footer a { color: #A9C2A4; text-decoration: none; transition: 0.3s; }
        footer a:hover { color: white; }
    </style>
</head>
<body>

    <div class="top-banner text-center position-relative fw-bold">Just Restocked | Shop Our Fragrance Collection</div>

    <nav class="navbar-custom py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <a href="koleksi.php" class="text-dark text-decoration-none fw-bold"><i class="bi bi-arrow-left me-2"></i>KEMBALI</a>
            </div>
            <div class="d-flex align-items-center gap-4">
                <span class="text-dark fw-bold">Halo, <?= $username ?>!</span>
                <a href="keranjang.php" class="text-dark text-decoration-none"><i class="bi bi-bag fs-5 align-middle"></i></a>
                <a href="pesanan.php" class="text-dark text-decoration-none"><i class="bi bi-box-seam fs-5 align-middle"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="min-height: 50vh;">
        <h1 class="serif-text fw-bold mb-2" style="font-size: 3rem;">Pesanan Saya</h1>
        <p class="text-muted mb-5">Pantau status pesanan dan riwayat belanja Anda di sini.</p>
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <?php
                $query_pesanan = mysqli_query($conn, "SELECT * FROM pesanan WHERE username='$username' ORDER BY tanggal_pesan DESC");
                
                if(mysqli_num_rows($query_pesanan) == 0) {
                    echo "<div class='text-center py-5'>
                            <i class='bi bi-box-seam text-muted' style='font-size: 4rem;'></i>
                            <h4 class='fw-bold mt-3'>Belum ada pesanan</h4>
                            <p class='text-muted'>Anda belum melakukan transaksi apapun.</p>
                            <a href='koleksi.php' class='btn btn-dark rounded-pill px-4 mt-2'>Mulai Belanja</a>
                          </div>";
                } else {
                    while($order = mysqli_fetch_array($query_pesanan)) {
                        $id_pesan = $order['id_pesanan'];
                        $tanggal = date('d M Y, H:i', strtotime($order['tanggal_pesan']));
                        
                        $status_saat_ini = $order['status_pesanan'];
                        $bg_color = "#E2A76F"; 
                        $icon = "bi-box-seam";
                        
                        if($status_saat_ini == 'Dikirim') {
                            $bg_color = "#0dcaf0"; 
                            $icon = "bi-truck";
                        } elseif($status_saat_ini == 'Selesai') {
                            $bg_color = "#198754"; 
                            $icon = "bi-check-circle-fill";
                        }
                        
                        echo "
                        <div class='order-card'>
                            <div class='d-flex justify-content-between align-items-center border-bottom pb-3 mb-3'>
                                <div>
                                    <h5 class='fw-bold m-0' style='color: #1E3B27;'>{$order['id_pesanan']}</h5>
                                    <small class='text-muted'><i class='bi bi-calendar3 me-1'></i> $tanggal</small>
                                </div>
                                <span class='status-badge' style='background-color: {$bg_color};'><i class='bi {$icon} me-1'></i> {$status_saat_ini}</span>
                            </div>";
                            
                        $query_detail = mysqli_query($conn, "SELECT dp.jumlah, p.nama, p.harga, p.gambar FROM detail_pesanan dp JOIN produk p ON dp.id_produk = p.id_produk WHERE dp.id_pesanan = '$id_pesan'");
                        
                        if(mysqli_num_rows($query_detail) > 0) {
                            echo "<div class='item-list mb-3'>";
                            while($item = mysqli_fetch_array($query_detail)) {
                                $sub = $item['harga'] * $item['jumlah'];
                                echo "
                                <div class='d-flex justify-content-between align-items-center mb-2 border-bottom pb-2'>
                                    <div class='d-flex align-items-center'>
                                        <img src='{$item['gambar']}' style='width: 40px; height: 40px; object-fit: cover; border-radius: 5px; margin-right: 15px;'>
                                        <div>
                                            <h6 class='m-0 fw-bold' style='font-size: 13px;'>{$item['nama']}</h6>
                                            <small class='text-muted'>x{$item['jumlah']}</small>
                                        </div>
                                    </div>
                                    <small class='fw-bold'>Rp " . number_format($sub, 0, ',', '.') . "</small>
                                </div>";
                            }
                            echo "</div>";
                        } else {
                            echo "<div class='item-list mb-3 text-center text-danger small fst-italic'>Detail barang tidak ditemukan karena error transaksi sebelumnya.</div>";
                        }
                        
                        echo "
                            <div class='d-flex justify-content-between align-items-center mt-3'>
                                <div>
                                    <span class='text-muted small d-block'>Metode: <strong>{$order['metode_pembayaran']}</strong></span>
                                </div>
                                <div class='text-end'>
                                    <span class='text-muted small'>Total Bayar</span>
                                    <h5 class='fw-bold text-success m-0'>Rp " . number_format($order['total_bayar'], 0, ',', '.') . "</h5>
                                </div>
                            </div>
                        </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

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
</body>
</html>