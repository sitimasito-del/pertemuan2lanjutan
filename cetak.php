<?php
include 'koneksi.php';

$id = $_GET['id'];

// ambil data peminjaman
$p = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT * FROM peminjaman WHERE id='$id'")
);

// hitung durasi
$tgl1 = new DateTime($p['tgl_pinjam']);
$tgl2 = new DateTime($p['tgl_kembali']);
$hari = $tgl1->diff($tgl2)->days;
if($hari < 1){ $hari = 1; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Peminjaman OUTTREN</title>
  <style>
    body {
      font-family: Arial;
      font-size: 12px;
    }
    .struk {
      width: 260px;
      margin: auto;
    }
    .center {
      text-align: center;
    }
    hr {
      border: 1px dashed black;
    }
    table {
      width: 100%;
    }
    td {
      padding: 3px 0;
    }
  </style>
</head>

<body onload="window.print()">

<div class="struk">

  <div class="center">
    <img src="img/logo.png" width="80"><br>
    <b>OUTTREN</b><br>
    Peminjaman Alat Mendaki<br>
    ------------------------
  </div>

  <hr>

  <p>
    Nama : <?= htmlspecialchars($p['nama']); ?><br>
    WA   : <?= htmlspecialchars($p['whatsapp']); ?><br>
    Durasi : <?= $hari; ?> hari
  </p>

  <hr>

  <table>
    <?php
    $total = 0;

    $detail = mysqli_query($conn,"
      SELECT v.varian, d.harga
      FROM peminjaman_detail d
      JOIN alat_varian v ON d.alat_varian_id = v.id
      WHERE d.peminjaman_id = '$id'
    ");

    while($d = mysqli_fetch_assoc($detail)){
      $subtotal = $d['harga'] * $hari;
      $total += $subtotal;
    ?>
    <tr>
      <td><?= htmlspecialchars($d['varian']); ?></td>
      <td align="right">Rp<?= number_format($subtotal); ?></td>
    </tr>
    <?php } ?>
  </table>

  <hr>

  <table>
    <tr>
      <td><b>Total</b></td>
      <td align="right"><b>Rp<?= number_format($total); ?></b></td>
    </tr>
  </table>

  <hr>

  <div class="center">
    Terima Kasih<br>
    Selamat Berpetualang 🌄<br><br>
    <small>
      *Simpan struk ini<br>
      *Kerusakan alat tanggung jawab peminjam
    </small>
  </div>

</div>

</body>
</html>