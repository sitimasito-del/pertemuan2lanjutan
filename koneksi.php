<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "outtren"; // ganti sesuai DB kamu

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
?>