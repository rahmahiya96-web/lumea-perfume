<?php
session_start();
include 'koneksi.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Tamu';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Luméa - Koleksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('uploads/bg-mawar.jpg') no-repeat center center/cover; background-attachment: fixed; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .top-banner { background-color: #6F8A70; color: black; font-size: 12px; padding: 5px 0; }
        .serif-text { font-family: 'Playfair Display', serif; }
        .navbar-custom { background-color: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        .search-box { background: rgba(0,0,0,0.05); border-radius: 20px; padding: 5px 15px; border: 1px solid rgba(0,0,0,0.1); }
        .search-box input { background: transparent; border: none; color: black; outline: none; width: 200px; }
        .sidebar { background-color: rgba(238, 199, 204, 0.85); min-height: 100vh; padding-top: 50px; }
        .sidebar a { display: block; color: #333; text-decoration: none; font-weight: 600; font-size: 14px; padding: 15px 0; text-align: center; letter-spacing: 1px; transition: 0.3s; }
        .sidebar a:hover { background-color: rgba(255,255,255,0.6); }
        .sidebar a.aktif-menu { background-color: rgba(255,255,255,0.8); color: #1E3B27; }
        .sidebar h5 { color: #1E3B27; font-weight: 600; letter-spacing: 2px; margin-bottom: 30px; text-align: center;}
        .product-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border-radius: 15px; padding: 20px; text-align: center; border: 1px solid rgba(255,255,255,0.4); position: relative; transition: 0.3s; }
        .product-card:hover { transform: scale(1.03); box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 2; }
        .product-card img { width: 100%; border-radius: 10px; margin-bottom: 15px; mix-blend-mode: multiply; }
        .btn-sage { background-color: #A9C2A4; color: black; font-weight: 500; border-radius: 10px; border: none; padding: 8px 30px; font-size: 13px; transition: 0.3s; }
        .btn-sage:hover { background-color: #8fa685; }
        .badge-sale { position: absolute; top: 15px; right: 15px; font-size: 11px; padding: 5px 10px; border-radius: 5px; font-weight: bold;}
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
                <a href="home.php" class="text-dark text-decoration-none fw-bold">HOME</a>
                <!-- Form PHP dihilangkan, sekarang menggunakan Javascript murni via onkeyup -->
                <div class="d-flex align-items-center search-box ms-3">
                    <i class="bi bi-search text-dark me-2"></i>
                    <input type="text" id="inputCari" onkeyup="terapkanFilter()" placeholder="Cari parfum...">
                </div>
            </div>
            <div class="d-flex align-items-center gap-4">
                <span class="text-dark fw-bold">Halo, <?= $username ?>!</span>
                <a href="keranjang.php" class="text-dark text-decoration-none" title="Keranjang"><i class="bi bi-bag fs-5 align-middle"></i></a>
                <a href="pesanan.php" class="text-dark text-decoration-none" title="Pesanan Saya"><i class="bi bi-box-seam fs-5 align-middle"></i></a>
            </div>
        </div>
    </nav>

    <div class="row g-0">
        <div class="col-md-2 sidebar" id="menuKategori">
            <h5>KATEGORI</h5>
            <a href="#" onclick="filterKategori('BEST SELLER', this)">BEST SELLER</a>
            <a href="#" onclick="filterKategori('NEW RELEASE', this)">NEW RELEASE</a>
            <a href="#" onclick="filterKategori('FEMININE', this)">FEMININE</a>
            <a href="#" onclick="filterKategori('MASCULINE', this)">MASCULINE</a>
            <a href="#" onclick="filterKategori('ANY GENDER', this)">ANY GENDER</a>
            <a href="#" onclick="filterKategori('ALL', this)" class="aktif-menu">ALL</a>
        </div>

        <div class="col-md-10 p-5">
            <div class="row g-4 justify-content-center pt-2" id="daftarProduk">
                <?php
                // Tampilkan SEMUA produk tanpa terkecuali, biarkan Javascript yang menyembunyikannya
                $data = mysqli_query($conn, "SELECT * FROM produk");
                while($row = mysqli_fetch_array($data)): 
                    $badge = "";
                    if ($row['status'] == 'BEST SELLER') {
                        $badge = '<span class="badge-sale text-white" style="background-color: #E2A76F;">BEST SELLER</span>';
                    } elseif ($row['status'] == 'NEW RELEASE') {
                        $badge = '<span class="badge-sale text-black" style="background-color: #A9C2A4;">NEW RELEASE</span>';
                    }
                ?>
                <div class="col-md-4 item-produk" data-filter="<?= $row['kategori'] ?> <?= $row['status'] ?>">
                    <div class="product-card">
                        <?= $badge ?>
                        <img src="<?= $row['gambar'] ?>" alt="<?= $row['nama'] ?>" style="height: 200px; object-fit: cover;">
                        <!-- Tambahkan class 'nama-parfum' agar mudah ditangkap oleh Javascript -->
                        <h5 class="serif-text fw-bold m-0 nama-parfum"><?= $row['nama'] ?></h5>
                        <small class="text-muted d-block mb-2" style="font-size: 10px;"><?= $row['tag'] ?></small>
                        <p class="mb-3" style="font-size: 14px;">Rp. <?= number_format($row['harga'], 0, ',', '.') ?></p>
                        
                        <a href="produk.php?id=<?= $row['id_produk'] ?>" class="btn btn-sage w-100 mt-2 text-decoration-none d-block">LIHAT DETAIL</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <!-- Pesan jika produk tidak ditemukan -->
            <div id="pesanKosong" class="text-center text-muted mt-5 d-none">
                <i class="bi bi-search fs-1"></i>
                <h5 class="mt-3">Produk tidak ditemukan</h5>
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

    <script>
        let kategoriAktif = 'ALL';

        function filterKategori(kriteria, elemenMenu) {
            let menuLinks = document.querySelectorAll('#menuKategori a');
            menuLinks.forEach(link => link.classList.remove('aktif-menu'));
            elemenMenu.classList.add('aktif-menu');
            
            kategoriAktif = kriteria;
            terapkanFilter(); // Panggil fungsi utama
        }

        // Fungsi Utama untuk menggabungkan Filter Pencarian dan Filter Kategori
        function terapkanFilter() {
            let keyword = document.getElementById('inputCari').value.toLowerCase();
            let produkList = document.querySelectorAll('.item-produk');
            let jumlahTerlihat = 0;

            produkList.forEach(produk => {
                let namaProduk = produk.querySelector('.nama-parfum').innerText.toLowerCase();
                let filterKategoriData = produk.getAttribute('data-filter');

                // Cek apakah produk cocok dengan kategori ATAU sedang di tab ALL
                let cocokKategori = (kategoriAktif === 'ALL' || filterKategoriData.includes(kategoriAktif));
                // Cek apakah produk cocok dengan ketikan di pencarian
                let cocokPencarian = namaProduk.includes(keyword);

                // Produk hanya tampil jika COCOK KEDUANYA
                if (cocokKategori && cocokPencarian) {
                    produk.style.display = 'block';
                    jumlahTerlihat++;
                } else {
                    produk.style.display = 'none';
                }
            });

            // Munculkan pesan jika produk habis disaring
            if(jumlahTerlihat === 0) {
                document.getElementById('pesanKosong').classList.remove('d-none');
            } else {
                document.getElementById('pesanKosong').classList.add('d-none');
            }
        }
    </script>
</body>
</html>