<?php
session_start();
include 'koneksi.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Tamu';

// Tangkap ID dari URL (contoh: produk.php?id=1)
if(isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    // Ambil data produk dari database berdasarkan ID
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $data_produk = mysqli_fetch_array($query);
    
    // Jika ID tidak ditemukan di database, kembalikan ke koleksi
    if(!$data_produk) {
        header("Location: koleksi.php");
        exit;
    }
} else {
    // Jika URL tidak punya ID, kembalikan ke koleksi
    header("Location: koleksi.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Luméa - <?= $data_produk['nama'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FCF2F4; color: #333; overflow-x: hidden; }
        .top-banner { background-color: #6F8A70; color: black; font-size: 12px; padding: 5px 0; }
        .serif-text { font-family: 'Playfair Display', serif; }
        .navbar-custom { background-color: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        .btn-sage { background-color: #A9C2A4; color: black; font-weight: 500; border-radius: 20px; border: none; padding: 10px 40px; transition: 0.3s;}
        .btn-sage:hover { background-color: #8fa685; }
        .product-img-box { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;}
        .product-img-box img { width: 80%; border-radius: 10px; }
        .qty-box { border: 1px solid #ccc; border-radius: 20px; padding: 5px 15px; display: inline-block;}
        .qty-box span { cursor: pointer; padding: 0 10px; font-weight: bold; }
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
                <a href="keranjang.php" class="text-dark text-decoration-none" title="Keranjang"><i class="bi bi-bag fs-5 align-middle"></i></a>
                <a href="pesanan.php" class="text-dark text-decoration-none" title="Pesanan Saya"><i class="bi bi-box-seam fs-5 align-middle"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="row align-items-center">
            <div class="col-md-5 offset-md-1">
                <div class="product-img-box">
                    <img src="<?= $data_produk['gambar'] ?>" alt="Gambar Parfum">
                </div>
            </div>

            <div class="col-md-5 offset-md-1">
                <h1 class="serif-text fw-bold" style="font-size: 4rem;"><?= $data_produk['nama'] ?></h1>
                
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <span class="fw-bold text-muted" style="font-size: 12px; letter-spacing: 2px;"><?= $data_produk['tag'] ?></span>
                    <span class="fs-4 fw-bold">Rp. <?= number_format($data_produk['harga'], 0, ',', '.') ?></span>
                </div>

                <p class="mb-5 text-muted" style="font-size: 15px; line-height: 1.8;">
                    <?= $data_produk['deskripsi'] ?>
                </p>

                <div class="d-flex align-items-center gap-4 mb-4">
                    <span class="fw-bold" style="font-size: 14px;">JUMLAH</span>
                    <div class="qty-box">
                        <span onclick="ubahQty(-1)">-</span>
                        <span id="angkaQty">1</span>
                        <span onclick="ubahQty(1)">+</span>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button class="btn btn-outline-dark w-50 fw-bold py-3" style="border-radius: 20px; border-width: 2px;" onclick="tambahKeKeranjang(false)">ADD TO CART</button>
                    <button class="btn-sage w-50 fw-bold py-3 fs-6" onclick="tambahKeKeranjang(true)">BUY NOW</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mengirim data PHP ke Javascript
        const pNama = "<?= $data_produk['nama'] ?>";
        const pHarga = <?= $data_produk['harga'] ?>;
        const pGambar = "<?= $data_produk['gambar'] ?>";

        let qtySekarang = 1;
        function ubahQty(nilai) {
            qtySekarang += nilai;
            if(qtySekarang < 1) qtySekarang = 1; 
            document.getElementById('angkaQty').innerText = qtySekarang;
        }

        function tambahKeKeranjang(langsungBeli) {
            // Siapkan bungkusan data barang
            let itemBaru = {
                nama: pNama,
                harga: pHarga,
                gambar: pGambar,
                qty: qtySekarang
            };

            if(langsungBeli) {
                // --- JALUR BUY NOW ---
                // Simpan ke memori khusus "Beli Langsung", timpa yang lama
                let arrayBeliSekarang = [itemBaru]; 
                localStorage.setItem("beliSekarangLumea", JSON.stringify(arrayBeliSekarang));
        
                // Arahkan ke checkout dengan membawa penanda (mode=buynow) di URL
                window.location.href = "checkout.php?mode=buynow"; 
            } else {
                // --- JALUR ADD TO CART ---
                // Simpan ke keranjang utama
                let keranjang = JSON.parse(localStorage.getItem("keranjangLumea")) || [];
                let indeks = keranjang.findIndex(item => item.nama === pNama);
        
                if(indeks !== -1) {
                    keranjang[indeks].qty += qtySekarang;
                } else {
                    keranjang.push(itemBaru);
                }
        
                localStorage.setItem("keranjangLumea", JSON.stringify(keranjang));
        
                // Arahkan ke halaman keranjang
                window.location.href = "keranjang.php"; 
            }
        }
    </script>
</body>
</html>