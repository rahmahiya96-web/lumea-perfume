<?php
session_start();
include 'koneksi.php';

// ==========================================
// 1. LOGIKA REGISTER (DAFTAR AKUN BARU)
// ==========================================
if(isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username_reg']);
    $password_asli = $_POST['password_reg'];
    
    // Mengacak Password 
    $password_hash = password_hash($password_asli, PASSWORD_DEFAULT);
    $role = 'customer'; 

    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if(mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Gagal: Username sudah terdaftar! Silakan gunakan nama lain.');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$password_hash', '$role')");
        echo "<script>alert('Registrasi berhasil! Silakan Login menggunakan akun tersebut.');</script>";
    }
}

// ==========================================
// 2. LOGIKA LOGIN (MASUK AKUN)
// ==========================================
if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if(mysqli_num_rows($cek) === 1) {
        $data = mysqli_fetch_assoc($cek);
        
        if(password_verify($password, $data['password']) || $data['password'] === $password) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            $tujuan = ($data['role'] == 'admin') ? 'admin.php' : 'home.php';
            
            // Jembatan Rahasia ke LocalStorage agar Navbar tetap jalan
            echo "<script>
                localStorage.setItem('username', '".$data['username']."');
                window.location.href = '".$tujuan."';
            </script>";
            exit;
            
        } else {
            echo "<script>alert('Gagal: Password yang Anda masukkan salah!');</script>";
        }
    } else {
        echo "<script>alert('Gagal: Username tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Luméa - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), url('bglg-mawar.png') no-repeat center center/cover;
            height: 100vh;
            color: #333;
            overflow-x: hidden;
        }
        .login-card {
            background-color: rgba(252, 242, 244, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: 0.3s;
        }
        .btn-sage { background-color: #A9C2A4; color: black; font-weight: 600; border-radius: 10px; border: none; padding: 10px; transition: 0.3s;}
        .btn-sage:hover { background-color: #8fa685; }
        .text-shadow-black { text-shadow: 2px 2px 6px rgba(0,0,0,0.8); }
        .form-control:focus { box-shadow: none; border-color: #A9C2A4; }
    </style>
</head>
<body>
    <div class="container mt-5 pt-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-white text-shadow-black">
                <h1 class="font-playfair fw-bold mb-3" style="font-size: 3rem; font-family: 'Playfair Display', serif; color: #1E3B27; text-shadow: 1px 1px 3px rgba(255,255,255,0.5);">LUMÉA PERFUME</h1>
                <h2 class="font-playfair fst-italic" style="font-size: 2.5rem; line-height: 1.2; font-family: 'Playfair Display', serif;">
                    Elevate everyday<br>moments to<br>extraordinary.
                </h2>
            </div>
            
            <div class="col-md-5 offset-md-1">
                <div class="login-card text-center">
                    
                    <h3 id="form-title" class="fw-bold mb-3" style="color: #E5989B;">Welcome back!</h3>
                    <p id="form-subtitle" class="mb-4" style="font-size: 14px;">Kindly fill in your login details to proceed</p>
                    
                    <form method="POST" action="login.php" id="form-login">
                        <input type="text" name="username" class="form-control mb-3 py-2" placeholder="Username" style="border-radius: 10px;" required>
                        <input type="password" name="password" class="form-control mb-4 py-2" placeholder="Password" style="border-radius: 10px;" required>
                        
                        <button type="submit" name="login" class="btn-sage w-100 mb-3">Login</button>
                        <p style="font-size: 13px; margin: 0;">Don't have an account? <a href="#" onclick="toggleForm()" style="color: #6F8A70; font-weight: bold; text-decoration: none;">Register here</a></p>
                    </form>

                    <form method="POST" action="login.php" id="form-register" class="d-none">
                        <input type="text" name="username_reg" class="form-control mb-3 py-2" placeholder="Buat Username Baru" style="border-radius: 10px;" required>
                        <input type="password" name="password_reg" class="form-control mb-4 py-2" placeholder="Buat Password (Min. 8 karakter)" style="border-radius: 10px;" required minlength="8">
                        
                        <button type="submit" name="register" class="btn w-100 mb-3 fw-bold" style="background-color: #1E3B27; color: white; border-radius: 10px; padding: 10px;">Sign Up</button>
                        <p style="font-size: 13px; margin: 0;">Already have an account? <a href="#" onclick="toggleForm()" style="color: #6F8A70; font-weight: bold; text-decoration: none;">Login here</a></p>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            // Ambil elemen form
            const fLogin = document.getElementById('form-login');
            const fRegister = document.getElementById('form-register');
            const fTitle = document.getElementById('form-title');
            const fSubtitle = document.getElementById('form-subtitle');

            // Cek apakah form login sedang disembunyikan
            if (fLogin.classList.contains('d-none')) {
                // Tampilkan Login
                fLogin.classList.remove('d-none');
                fRegister.classList.add('d-none');
                fTitle.innerText = "Welcome back!";
                fSubtitle.innerText = "Kindly fill in your login details to proceed";
            } else {
                // Tampilkan Register
                fLogin.classList.add('d-none');
                fRegister.classList.remove('d-none');
                fTitle.innerText = "Create Account";
                fSubtitle.innerText = "Join our community of fragrance lovers";
            }
        }
    </script>
</body>
</html>