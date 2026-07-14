<?php
session_start();
include 'koneksi.php';

// LOGIKA LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login_admin.php");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// ==========================================
// 1. LOGIKA TAMBAH PRODUK (CREATE)
// ==========================================
if(isset($_POST['simpan_produk'])) {
    $nama = $_POST['nama']; 
    $kategori = $_POST['kategori']; 
    $status = $_POST['status']; 
    $tag = $_POST['tag'];
    $harga = $_POST['harga']; 
    $deskripsi = $_POST['deskripsi'];

    $nama_file = $_FILES['gambar']['name']; 
    $tmp_file = $_FILES['gambar']['tmp_name']; 
    $path = "uploads/" . $nama_file;
    
    if(move_uploaded_file($tmp_file, $path)) {
        mysqli_query($conn, "INSERT INTO produk (nama, kategori, status, tag, harga, deskripsi, gambar) 
                            VALUES ('$nama', '$kategori', '$status', '$tag', '$harga', '$deskripsi', '$path')");
        header("Location: admin.php?page=produk");
    } else {
        echo "<script>alert('Gagal upload gambar!');</script>";
    }
}

// ==========================================
// 2. LOGIKA EDIT PRODUK (UPDATE) -> FITUR BARU
// ==========================================
if(isset($_POST['update_produk'])) {
    $id_produk = $_POST['id_produk'];
    $nama = $_POST['nama']; 
    $kategori = $_POST['kategori']; 
    $status = $_POST['status']; 
    $tag = $_POST['tag'];
    $harga = $_POST['harga']; 
    $deskripsi = $_POST['deskripsi'];

    // Cek apakah admin mengupload gambar baru untuk mengganti gambar lama
    if($_FILES['gambar']['name'] != '') {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_file = $_FILES['gambar']['tmp_name'];
        $path = "uploads/" . $nama_file;
        move_uploaded_file($tmp_file, $path);
        
        // Update data beserta gambar baru
        mysqli_query($conn, "UPDATE produk SET nama='$nama', kategori='$kategori', status='$status', tag='$tag', harga='$harga', deskripsi='$deskripsi', gambar='$path' WHERE id_produk='$id_produk'");
    } else {
        // Update data tanpa mengubah gambar lama
        mysqli_query($conn, "UPDATE produk SET nama='$nama', kategori='$kategori', status='$status', tag='$tag', harga='$harga', deskripsi='$deskripsi' WHERE id_produk='$id_produk'");
    }
    header("Location: admin.php?page=produk");
}

// ==========================================
// 3. LOGIKA HAPUS PRODUK (DELETE)
// ==========================================
if(isset($_GET['hapus_produk'])) {
    $id_produk = $_GET['hapus_produk'];
    $data_produk = mysqli_fetch_array(mysqli_query($conn, "SELECT gambar FROM produk WHERE id_produk='$id_produk'"));
    $file_gambar = $data_produk['gambar'];

    if(file_exists($file_gambar)) {
        unlink($file_gambar);
    }
    mysqli_query($conn, "DELETE FROM produk WHERE id_produk='$id_produk'");
    header("Location: admin.php?page=produk");
}

// ==========================================
// 4. LOGIKA UPDATE STATUS PESANAN
// ==========================================
if(isset($_POST['update_status'])) {
    $id_p = $_POST['id_pesanan'];
    $st_p = $_POST['status_pesanan'];
    mysqli_query($conn, "UPDATE pesanan SET status_pesanan='$st_p' WHERE id_pesanan='$id_p'");
    header("Location: admin.php?page=pesanan");
}

// --- LOGIKA UPDATE PENGATURAN TOKO (BANNER & FOOTER) ---
if(isset($_POST['simpan_toko'])) {
    $deskripsi_footer = $_POST['deskripsi_footer'];
    $email_toko = $_POST['email_toko'];
    $telepon_toko = $_POST['telepon_toko'];

    if($_FILES['banner_baru']['name'] != '') {
        $nama_file = $_FILES['banner_baru']['name'];
        $tmp_file = $_FILES['banner_baru']['tmp_name'];
        $path_banner = "uploads/" . $nama_file;
        move_uploaded_file($tmp_file, $path_banner);
        mysqli_query($conn, "UPDATE konfigurasi_toko SET link_banner='$nama_file', deskripsi_footer='$deskripsi_footer', email_toko='$email_toko', telepon_toko='$telepon_toko' WHERE id=1");
    } else {
        mysqli_query($conn, "UPDATE konfigurasi_toko SET deskripsi_footer='$deskripsi_footer', email_toko='$email_toko', telepon_toko='$telepon_toko' WHERE id=1");
    }
    header("Location: admin.php?page=toko");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard - Luméa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; margin: 0; }
        .sidebar { background-color: #1E3B27; height: 100vh; position: fixed; width: 250px; color: white; padding-top: 30px; overflow-y: auto; z-index: 1000;}
        .sidebar h4 { letter-spacing: 2px; }
        .sidebar a { color: rgba(255,255,255,0.7); text-decoration: none; padding: 12px 20px; display: block; font-weight: 500; transition: 0.3s; border-radius: 8px; margin: 0 15px 5px; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.1); color: white; }
        .content-area { margin-left: 250px; padding: 40px; width: calc(100% - 250px); min-height: 100vh; }
        .card-custom { background: white; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 25px; }
        .table-responsive { overflow-x: auto; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-center fw-bold mb-5 text-white">LUMÉA ADMIN</h4>
        <a href="?page=dashboard" class="<?= ($page == 'dashboard') ? 'active' : '' ?>"><i class="bi bi-grid me-2"></i> Dashboard</a>
        <a href="?page=produk" class="<?= ($page == 'produk') ? 'active' : '' ?>"><i class="bi bi-box-seam me-2"></i> Manajemen Produk</a>
        <a href="?page=user" class="<?= ($page == 'user') ? 'active' : '' ?>"><i class="bi bi-people me-2"></i> Data Pelanggan</a>
        <a href="?page=pesanan" class="<?= ($page == 'pesanan') ? 'active' : '' ?>"><i class="bi bi-receipt me-2"></i> Daftar Pesanan</a>
        <a href="?page=toko" class="<?= ($page == 'toko') ? 'active' : '' ?>"><i class="bi bi-shop me-2"></i> Pengaturan Toko</a>
        <a href="?logout=true" class="text-danger mt-5" onclick="return confirm('Yakin ingin keluar?')"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </div>

    <div class="content-area">
        
        <?php if($page == 'dashboard'): ?>
            <h2 class="fw-bold mb-4" style="color: #1E3B27;">Ringkasan Toko</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card-custom text-center border-bottom border-success border-4">
                        <h1 class="fw-bold text-success"><?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk")) ?></h1>
                        <span class="text-muted small">Total Produk</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-custom text-center border-bottom border-primary border-4">
                        <h1 class="fw-bold text-primary"><?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='customer'")) ?></h1>
                        <span class="text-muted small">Pelanggan Terdaftar</span>
                    </div>
                </div>
            </div>

        <?php elseif($page == 'produk'): ?>
            <h2 class="fw-bold mb-4" style="color: #1E3B27;">Manajemen Produk</h2>
            
            <?php
            // Deteksi Mode Edit
            $is_edit = false;
            $edit_data = ['nama'=>'', 'kategori'=>'', 'status'=>'', 'tag'=>'', 'harga'=>'', 'deskripsi'=>'', 'gambar'=>''];
            if(isset($_GET['edit_produk'])) {
                $is_edit = true;
                $id_edit = $_GET['edit_produk'];
                $query_edit = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_edit'");
                if(mysqli_num_rows($query_edit) > 0) {
                    $edit_data = mysqli_fetch_array($query_edit);
                }
            }
            ?>

            <div class="card-custom mb-4">
                <h5 class="fw-bold border-bottom pb-3 mb-3"><?= $is_edit ? '<i class="bi bi-pencil-square text-warning me-2"></i>Edit Detail Produk' : 'Tambah Produk Baru' ?></h5>
                
                <form method="POST" action="admin.php?page=produk" class="row g-3" enctype="multipart/form-data">
                    <?php if($is_edit): ?>
                        <input type="hidden" name="id_produk" value="<?= $id_edit ?>">
                    <?php endif; ?>

                    <div class="col-md-3">
                        <label class="small text-muted fw-bold">Nama Parfum</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Parfum" value="<?= $edit_data['nama'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted fw-bold">Kategori Filter</label>
                        <select name="kategori" class="form-select" required>
                            <option value="FEMININE" <?= $edit_data['kategori'] == 'FEMININE' ? 'selected' : '' ?>>FEMININE</option>
                            <option value="MASCULINE" <?= $edit_data['kategori'] == 'MASCULINE' ? 'selected' : '' ?>>MASCULINE</option>
                            <option value="ANY GENDER" <?= $edit_data['kategori'] == 'ANY GENDER' ? 'selected' : '' ?>>ANY GENDER</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted fw-bold">Status Badge</label>
                        <select name="status" class="form-select" required>
                            <option value="NORMAL" <?= $edit_data['status'] == 'NORMAL' ? 'selected' : '' ?>>NORMAL</option>
                            <option value="BEST SELLER" <?= $edit_data['status'] == 'BEST SELLER' ? 'selected' : '' ?>>BEST SELLER</option>
                            <option value="NEW RELEASE" <?= $edit_data['status'] == 'NEW RELEASE' ? 'selected' : '' ?>>NEW RELEASE</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted fw-bold">Tag Singkat</label>
                        <input type="text" name="tag" class="form-control" placeholder="Tag Singkat" value="<?= $edit_data['tag'] ?>">
                    </div>
                    <div class="col-md-2 mt-3">
                        <label class="small text-muted fw-bold">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="Harga" value="<?= $edit_data['harga'] ?>" required>
                    </div>
                    <div class="col-md-7 mt-3">
                        <label class="small text-muted fw-bold">Deskripsi Produk</label>
                        <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi Panjang" value="<?= $edit_data['deskripsi'] ?>">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="small text-muted fw-bold">Foto Produk</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" <?= $is_edit ? '' : 'required' ?>>
                        <?php if($is_edit): ?>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <?php if($is_edit): ?>
                            <button type="submit" name="update_produk" class="btn btn-warning fw-bold text-dark px-4 me-2">Simpan Perubahan</button>
                            <a href="admin.php?page=produk" class="btn btn-secondary fw-bold px-4">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="simpan_produk" class="btn btn-success fw-bold px-4">Simpan Produk</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card-custom table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr><th>Gambar</th><th>Nama</th><th>Kategori</th><th>Status</th><th>Harga</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = mysqli_query($conn, "SELECT * FROM produk");
                        while($row = mysqli_fetch_array($data)) {
                            echo "<tr>
                                <td><img src='{$row['gambar']}' width='40' style='border-radius:5px;'></td>
                                <td><strong>{$row['nama']}</strong><br><small class='text-muted'>{$row['tag']}</small></td>
                                <td>{$row['kategori']}</td>
                                <td><span class='badge bg-light text-dark border'>{$row['status']}</span></td>
                                <td>Rp " . number_format($row['harga'],0,',','.') . "</td>
                                <td>
                                    <a href='admin.php?page=produk&edit_produk={$row['id_produk']}' class='btn btn-warning btn-sm text-dark me-1' title='Edit'><i class='bi bi-pencil-square'></i></a>
                                    
                                    <a href='admin.php?page=produk&hapus_produk={$row['id_produk']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus produk ini?\")' title='Hapus'><i class='bi bi-trash'></i></a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php elseif($page == 'user'): ?>
            <h2 class="fw-bold mb-4" style="color: #1E3B27;">Data Pelanggan</h2>
            <div class="card-custom table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr><th>ID</th><th>Username</th><th>Role</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = mysqli_query($conn, "SELECT * FROM users");
                        while($row = mysqli_fetch_array($data)) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td><strong>{$row['username']}</strong></td>
                                <td><span class='badge bg-secondary'>{$row['role']}</span></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php elseif($page == 'pesanan'): ?>
            <h2 class="fw-bold mb-4" style="color: #1E3B27;">Daftar Pesanan Masuk</h2>
            <div class="card-custom table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr><th>No. Order</th><th>Penerima</th><th>Total Bayar</th><th>Metode</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $data_pesanan = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY tanggal_pesan DESC");
                        if(mysqli_num_rows($data_pesanan) > 0) {
                            while($row = mysqli_fetch_array($data_pesanan)) {
                                $tgl = date('d/m/Y H:i', strtotime($row['tanggal_pesan']));
            
                                // Pilihan Status Otomatis Terpilih
                                $sel1 = ($row['status_pesanan'] == 'Sedang Dikemas') ? 'selected' : '';
                                $sel2 = ($row['status_pesanan'] == 'Dikirim') ? 'selected' : '';
                                $sel3 = ($row['status_pesanan'] == 'Selesai') ? 'selected' : '';

                                echo "<tr>
                                    <td><strong>{$row['id_pesanan']}</strong></td>
                                    <td>{$row['nama_penerima']} <br><small class='text-muted'>({$row['username']})</small></td>
                                    <td class='text-success fw-bold'>Rp " . number_format($row['total_bayar'],0,',','.') . "</td>
                                    <td>
                                        <!-- Dropdown Status yang Langsung Update saat dipilih -->
                                        <form method='POST' action='admin.php?page=pesanan'>
                                            <input type='hidden' name='id_pesanan' value='{$row['id_pesanan']}'>
                                            <input type='hidden' name='update_status' value='1'>
                                            <select name='status_pesanan' class='form-select form-select-sm border-secondary' onchange='this.form.submit()'>
                                                <option value='Sedang Dikemas' $sel1>Sedang Dikemas</option>
                                                <option value='Dikirim' $sel2>Dikirim</option>
                                                <option value='Selesai' $sel3>Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>$tgl</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-muted'>Belum ada data pesanan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php elseif($page == 'toko'): 
            $query_toko = mysqli_query($conn, "SELECT * FROM konfigurasi_toko WHERE id=1");
            $data_toko = mysqli_fetch_array($query_toko);
        ?>
            <h2 class="fw-bold mb-4" style="color: #1E3B27;">Pengaturan Toko</h2>
            <div class="row">
                <div class="col-md-7">
                    <div class="card-custom">
                        <form method="POST" action="admin.php?page=toko" enctype="multipart/form-data">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Ubah Banner Utama</h5>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold">Upload Gambar Banner Baru</label>
                                <input type="file" name="banner_baru" class="form-control" accept="image/*">
                                <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengganti banner saat ini (Banner aktif: <strong><?= $data_toko['link_banner'] ?></strong>).</small>
                            </div>
                            <h5 class="fw-bold mb-3 border-bottom pb-2 mt-4">Informasi Footer Website</h5>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Deskripsi Toko (Tentang Kami)</label>
                                <textarea name="deskripsi_footer" class="form-control" rows="4" required><?= $data_toko['deskripsi_footer'] ?></textarea>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Email Bantuan</label>
                                    <input type="email" name="email_toko" class="form-control" value="<?= $data_toko['email_toko'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Telepon / WhatsApp</label>
                                    <input type="text" name="telepon_toko" class="form-control" value="<?= $data_toko['telepon_toko'] ?>" required>
                                </div>
                            </div>
                            <button type="submit" name="simpan_toko" class="btn btn-success fw-bold px-4">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>