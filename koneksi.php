<?php
// koneksi.php
$host = "localhost";
$user = "root";       // Default username Laragon
$pass = "";           // Default password Laragon kosong
$db   = "lumea_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>