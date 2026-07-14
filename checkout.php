<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$pesanan_sukses = false;
$id_order_baru = "";
$nama_pemesan = "";
$mode_checkout = ""; // Untuk mengingat apakah ini buynow atau cart

if(isset($_POST['proses_checkout'])) {
    $username = $_SESSION['username'];
    $nama_penerima = $_POST['nama_penerima'];
    $hp = $_POST['hp'];
    $provinsi = $_POST['provinsi'];
    $kota = $_POST['kota'];
    $alamat = $_POST['alamat_lengkap'];
    $metode_bayar = $_POST['metode_bayar'];
    $mode_checkout = $_POST['checkout_mode']; // Tangkap mode dari input hidden
    
    $alamat_lengkap = "$alamat, $kota, $provinsi (HP: $hp)";
    $cart_data = json_decode($_POST['cart_data'], true);
    
    if(!empty($cart_data)) {
        $id_pesanan = "LUM-" . rand(10000, 99999);
        $subtotal = 0;
        foreach($cart_data as $item) {
            $subtotal += ($item['harga'] * $item['qty']);
        }
        $total_bayar = $subtotal + 9000;
        
        mysqli_query($conn, "INSERT INTO pesanan (id_pesanan, username, nama_penerima, alamat_penerima, total_bayar, metode_pembayaran) 
                             VALUES ('$id_pesanan', '$username', '$nama_penerima', '$alamat_lengkap', '$total_bayar', '$metode_bayar')");
        
        foreach($cart_data as $item) {
            $nama_produk = $item['nama'];
            $qty = $item['qty'];
            
            $get_produk = mysqli_query($conn, "SELECT id_produk FROM produk WHERE nama='$nama_produk'");
            if($row_p = mysqli_fetch_assoc($get_produk)){
                $id_produk = $row_p['id_produk'];
                mysqli_query($conn, "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah) 
                     VALUES ('$id_pesanan', '$id_produk', '$qty')");
            }
        }
        
        $pesanan_sukses = true;
        $id_order_baru = $id_pesanan;
        $nama_pemesan = $nama_penerima;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
    
<head>
    <meta charset="UTF-8">
    <title>Luméa - Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FCF2F4; color: #333; overflow-x: hidden; }
        .top-banner { background-color: #6F8A70; color: black; font-size: 12px; padding: 5px 0; }
        .serif-text { font-family: 'Playfair Display', serif; }
        .navbar-custom { background-color: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        .form-control, .form-select { border: 1px solid #A9C2A4; border-radius: 10px; padding: 10px 15px; }
        .form-control:focus, .form-select:focus { box-shadow: none; border-color: #1E3B27; }
        .struk-card { background-color: white; border: 1px solid #A9C2A4; border-radius: 20px; padding: 30px; position: sticky; top: 100px; }
        .item-bg { background-color: #f8f9fa; padding: 10px; border-radius: 10px; margin-bottom: 10px; border: 1px solid #eee;}
        .btn-sage { background-color: #A9C2A4; color: black; font-weight: 500; border-radius: 15px; border: none; padding: 15px 40px; transition: 0.3s;}
        .btn-sage:hover { background-color: #8fa685; }
        .success-box { background: white; border-radius: 20px; padding: 60px 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); animation: fadeIn 0.6s ease-in-out;}
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        footer { background-color: #1E3B27; color: white; padding: 60px 0 20px; margin-top: 80px; }
    </style>
</head>
<body>

    <div class="top-banner text-center position-relative fw-bold">Just Restocked | Shop Our Fragrance Collection</div>

    <nav class="navbar-custom py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <a href="javascript:history.back()" class="text-dark text-decoration-none fw-bold"><i class="bi bi-arrow-left me-2"></i>KEMBALI</a>
                <a href="koleksi.php" class="text-dark text-decoration-none fw-bold">SHOP</a>
            </div>
            <div class="d-flex align-items-center gap-4">
                <span class="text-dark fw-bold">Halo, <?= $_SESSION['username'] ?>!</span>
                <a href="keranjang.php" class="text-dark text-decoration-none"><i class="bi bi-bag fs-5 align-middle"></i></a>
                <a href="pesanan.php" class="text-dark text-decoration-none"><i class="bi bi-box-seam fs-5 align-middle"></i></a>
            </div>
        </div>
    </nav>

    <?php if($pesanan_sukses): ?>
        <!-- Script untuk menghapus memori belanja yang tepat setelah sukses -->
        <script>
            let mode = "<?= $mode_checkout ?>";
            if(mode === 'buynow') {
                localStorage.removeItem("beliSekarangLumea");
            } else {
                localStorage.removeItem("keranjangLumea");
            }
        </script>
        
        <div class="container mt-5 mb-5" style="min-height: 50vh;">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="success-box">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                        <h2 class="serif-text fw-bold mt-4 mb-2">Pesanan Berhasil!</h2>
                        <p class="text-muted mb-4">Terima kasih <span class="fw-bold"><?= $nama_pemesan ?></span>. Pesanan Anda sedang kami proses.</p>
                        
                        <div class="p-3 mb-4 text-start" style="background-color: #f8f9fa; border-radius: 10px; border: 1px dashed #ccc;">
                            <small class="text-muted d-block mb-1">Nomor Pesanan:</small>
                            <h5 class="fw-bold m-0 text-success"><?= $id_order_baru ?></h5>
                        </div>

                        <div class="d-flex gap-3 justify-content-center mt-4">
                            <a href="koleksi.php" class="btn btn-outline-dark fw-bold px-4 rounded-pill">Belanja Lagi</a>
                            <a href="pesanan.php" class="btn btn-sage fw-bold px-4" style="border-radius: 50px;">Lacak Pesanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="container mt-5 mb-5">
            <h1 class="serif-text fw-bold mb-5" style="font-size: 2.5rem;">CHECKOUT</h1>
            
            <form id="formCheckout" method="POST" action="checkout.php" class="row">
                <!-- Data Tersembunyi -->
                <input type="hidden" name="cart_data" id="cartData">
                <input type="hidden" name="checkout_mode" id="inputMode">
                
                <!-- Form Kiri -->
                <div class="col-md-7 pe-md-5">
                    <h5 class="mb-4 fw-bold" style="color: #1E3B27;"><i class="bi bi-geo-alt me-2"></i>Informasi Pengiriman</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">NAMA LENGKAP</label>
                            <input type="text" name="nama_penerima" id="inputNama" class="form-control" value="<?= $_SESSION['username'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">NO. TELEPON / WHATSAPP</label>
                            <input type="number" name="hp" id="inputHp" class="form-control" placeholder="0812xxxxxx" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">PROVINSI</label>
                            <select name="provinsi" class="form-select" required>
                                <option value="Riau">Riau</option>
                                <option value="Sumatera Barat">Sumatera Barat</option>
                                <option value="DKI Jakarta">DKI Jakarta</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <!-- PERBAIKAN: KOTA DIUBAH JADI INPUT TEKS -->
                            <label class="form-label small fw-bold">KOTA / KABUPATEN</label>
                            <input type="text" name="kota" class="form-control" placeholder="Masukkan Kota/Kab." required>
                        </div>
                    </div>

                    <label class="form-label small fw-bold">ALAMAT LENGKAP (Jalan, RT/RW, Patokan)</label>
                    <textarea name="alamat_lengkap" id="inputAlamat" class="form-control mb-5" rows="3" placeholder="Contoh: Jl. Sudirman No. 12, Dekat minimarket..." required></textarea>
                    
                    <h5 class="mb-4 fw-bold" style="color: #1E3B27;"><i class="bi bi-wallet2 me-2"></i>Pembayaran</h5>
                    <label class="form-label small fw-bold">METODE PEMBAYARAN</label>
                    <select name="metode_bayar" class="form-select mb-4" required>
                        <option value="QRIS">QRIS</option>
                        <option value="Gopay">Gopay</option>
                        <option value="ShopeePay">ShopeePay</option>
                        <option value="Transfer Bank">Transfer Bank (BCA/Mandiri)</option>
                    </select>
                </div>

                <!-- Struk Kanan -->
                <div class="col-md-5">
                    <div class="struk-card shadow-sm">
                        <h4 class="serif-text mb-4 fw-bold border-bottom pb-3">Detail Pesanan</h4>
                        <div id="listBarangStruk" class="mb-4" style="max-height: 300px; overflow-y: auto;"></div>
                        <div class="d-flex justify-content-between text-secondary mb-2"><span>Subtotal Produk</span><span id="subtotalTeks">Rp. 0</span></div>
                        <div class="d-flex justify-content-between text-secondary mb-4"><span>Ongkos Kirim</span><span>Rp. 9.000</span></div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-4 mb-5" style="color: #1E3B27;"><span>Total Bayar</span><span id="totalTeks">Rp. 0</span></div>
                        
                        <button type="button" class="btn-sage w-100 fs-5 fw-bold" onclick="prosesPembayaran()">BELI SEKARANG</button>
                        <button type="submit" name="proses_checkout" id="submitAsli" class="d-none"></button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            // 1. CEK MODE DARI URL APAKAH BUY NOW ATAU CART
            const urlParams = new URLSearchParams(window.location.search);
            const mode = urlParams.get('mode');
            let keranjang = [];

            if(mode === 'buynow') {
                keranjang = JSON.parse(localStorage.getItem("beliSekarangLumea")) || [];
                document.getElementById('inputMode').value = 'buynow';
            } else {
                keranjang = JSON.parse(localStorage.getItem("keranjangLumea")) || [];
                document.getElementById('inputMode').value = 'cart';
            }

            if(keranjang.length === 0) {
                window.location.href = "koleksi.php"; 
            }

            // 2. TAMPILKAN STRUK
            let subtotal = 0;
            let strukHtml = "";
            keranjang.forEach(item => {
                subtotal += (item.harga * item.qty);
                strukHtml += `
                    <div class="d-flex align-items-center item-bg">
                        <img src="${item.gambar}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; margin-right: 15px;">
                        <div class="w-100 m-0">
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0 fw-bold" style="font-size: 13px;">${item.nama}</h6>
                                <small class="fw-bold">x${item.qty}</small>
                            </div>
                            <small class="text-muted">Rp. ${(item.harga * item.qty).toLocaleString('id-ID')}</small>
                        </div>
                    </div>`;
            });

            let totalAll = subtotal + 9000;
            document.getElementById('listBarangStruk').innerHTML = strukHtml;
            document.getElementById('subtotalTeks').innerText = "Rp. " + subtotal.toLocaleString('id-ID');
            document.getElementById('totalTeks').innerText = "Rp. " + totalAll.toLocaleString('id-ID');

            // 3. FUNGSI KLIK BAYAR
            function prosesPembayaran() {
                const nama = document.getElementById('inputNama').value;
                const hp = document.getElementById('inputHp').value;
                const kota = document.getElementsByName('kota')[0].value;
                const alamat = document.getElementById('inputAlamat').value;
                
                if(nama.trim() === "" || hp.trim() === "" || kota.trim() === "" || alamat.trim() === "") {
                    alert("Mohon lengkapi semua form pengiriman terlebih dahulu!");
                    return;
                }
                
                document.getElementById('cartData').value = JSON.stringify(keranjang);
                document.getElementById('submitAsli').click();
            }
        </script>
    <?php endif; ?>

    <footer>
        <div class="text-center small text-white-50 pt-4 pb-4">
            &copy; 2026 Luméa Perfume. Hak Cipta Dilindungi.
        </div>
    </footer>
</body>
</html>