<?php
include 'koneksi.php';
$id = $_GET['id'];

$detail = mysqli_query($conn,"
  SELECT alat_varian_id 
  FROM peminjaman_detail 
  WHERE peminjaman_id = '$id'
");

while($d = mysqli_fetch_assoc($detail)){
  mysqli_query($conn,"
    UPDATE alat_varian 
    SET stok = stok - 1 
    WHERE id = '{$d['alat_varian_id']}'
  ");
}

mysqli_query($conn,"
  UPDATE peminjaman 
  SET status = 'dipinjam' 
  WHERE id = '$id'
");

header("Location: admin.php");
exit;