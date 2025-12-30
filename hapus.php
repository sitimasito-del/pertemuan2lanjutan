<?php
include 'koneksi.php';

$id = $_GET['id'];

// ambil status peminjaman
$p = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT status FROM peminjaman WHERE id='$id'")
);

// JIKA STATUS DIPINJAM → KEMBALIKAN STOK DULU
if($p['status'] == 'dipinjam'){

  $detail = mysqli_query($conn,"
    SELECT alat_varian_id 
    FROM peminjaman_detail 
    WHERE peminjaman_id = '$id'
  ");

  while($d = mysqli_fetch_assoc($detail)){
    mysqli_query($conn,"
      UPDATE alat_varian 
      SET stok = stok + 1 
      WHERE id = '{$d['alat_varian_id']}'
    ");
  }
}

// hapus detail & header
mysqli_query($conn,"DELETE FROM peminjaman_detail WHERE peminjaman_id='$id'");
mysqli_query($conn,"DELETE FROM peminjaman WHERE id='$id'");

header("Location: admin.php");
exit;