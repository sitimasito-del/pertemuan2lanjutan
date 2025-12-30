<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("location:login.php");
  exit;
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin OUTTREN</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-wrapper">
  <h1>Admin OUTTREN</h1>
</div>

<div class="logout">
  <a href="logout.php">Logout</a>
</div>

<!-- ================= DATA PEMINJAMAN ================= -->
<div class="table-box">
<h3>Data Peminjaman</h3>
<table>
<tr>
  <th>Nama</th>
  <th>No WhatsApp</th>
  <th>Tanggal</th>
  <th>Jaminan</th>
  <th>Keterlambatan</th>
  <th>Denda</th>
  <th>Total Bayar</th>
  <th>Status</th>
  <th>Aksi</th>
</tr>

<?php
$q = mysqli_query($conn,"SELECT * FROM peminjaman ORDER BY id DESC");

if(mysqli_num_rows($q)==0){
  echo "<tr><td colspan='9'>Belum ada data</td></tr>";
}

while($p = mysqli_fetch_assoc($q)){

  // hitung keterlambatan
  $hari_telat = 0;
  $denda = 0;
  $hari_ini = date('Y-m-d');

  if($hari_ini > $p['tgl_kembali']){
    $tgl1 = new DateTime($p['tgl_kembali']);
    $tgl2 = new DateTime($hari_ini);
    $hari_telat = $tgl1->diff($tgl2)->days;
    $denda = $hari_telat * 10000;
  }

  // HITUNG TOTAL DARI DETAIL
  $total = 0;
  $detail = mysqli_query($conn,"
    SELECT harga FROM peminjaman_detail
    WHERE peminjaman_id = '".$p['id']."'
  ");
  while($d = mysqli_fetch_assoc($detail)){
    $total += $d['harga'];
  }

  $total_akhir = $total + $denda;
?>
<tr>
  <td><?= $p['nama']; ?></td>
  <td><?= $p['whatsapp']; ?></td>
  <td><?= $p['tgl_pinjam']; ?> s/d <?= $p['tgl_kembali']; ?></td>
  <td><?= $p['jaminan']; ?></td>
  <td><?= $hari_telat; ?> hari</td>
  <td>Rp<?= number_format($denda); ?></td>
  <td><b>Rp<?= number_format($total_akhir); ?></b></td>

  <td>
    <?php
    if($p['status']=='selesai'){
      echo "<b style='color:green'>Selesai</b>";
    }elseif($p['status']=='dipinjam'){
      echo "<b style='color:orange'>Dipinjam</b>";
    }else{
      echo "<b style='color:red'>Baru</b>";
    }
    ?>
  </td>

  <td>
    <?php if($p['status']=='baru'){ ?>
      <a href="ambil.php?id=<?= $p['id']; ?>">Ambil</a> |
    <?php } ?>

    <?php if($p['status']=='dipinjam'){ ?>
      <a href="kembali.php?id=<?= $p['id']; ?>">Kembalikan</a> |
    <?php } ?>

    <a href="cetak.php?id=<?= $p['id']; ?>">Cetak</a> |
    <a href="hapus.php?id=<?= $p['id']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
  </td>
</tr>
<?php } ?>
</table>
</div>

<!-- ================= STOK ALAT ================= -->
<div class="table-box">
<h3>Stok Alat (Per Varian)</h3>
<table>
<tr>
  <th>Nama Alat</th>
  <th>Varian</th>
  <th>Harga</th>
  <th>Stok</th>
</tr>

<?php
$q = mysqli_query($conn,"
  SELECT a.nama_alat, v.varian, v.harga, v.stok
  FROM alat_varian v
  JOIN alat a ON v.alat_id = a.id
");

while($v = mysqli_fetch_assoc($q)){
?>
<tr>
  <td><?= $v['nama_alat']; ?></td>
  <td><?= $v['varian']; ?></td>
  <td>Rp<?= number_format($v['harga']); ?></td>
  <td><?= $v['stok']; ?></td>
</tr>
<?php } ?>
</table>
</div>

</body>
</html>