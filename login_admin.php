<?php
session_start(); // Memulai sesi

// Cek apakah tombol login ditekan
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kunci Username dan Password (bisa kamu ganti sesuai selera)
    if ($username == 'admin' && $password == 'admin123') {
        $_SESSION['status_admin'] = "login_sukses";
        header("Location: admin.php"); // Pindah ke halaman admin
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Admin - Luméa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }</style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-sm p-4" style="width: 25rem; border-radius: 15px;">
        <h3 class="text-center fw-bold mb-4" style="color: #1E3B27;">Admin Luméa</h3>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger text-center p-2"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username (isi: admin)" required>
            <input type="password" name="password" class="form-control mb-4" placeholder="Password (isi: admin123)" required>
            <button type="submit" name="login" class="btn btn-success w-100 fw-bold" style="background-color: #1E3B27;">LOGIN</button>
        </form>
    </div>
</body>
</html>