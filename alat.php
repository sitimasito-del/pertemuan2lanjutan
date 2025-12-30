<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("location:login.php");
  exit;
}
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Data Alat</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<h2>Data Alat & Stok</h2>
<a href="tambah_alat.php">+ Tambah Alat</a>

<table border="1" cellpadding="8">
  <tr>
    <th>No</th>
    <th>Nama Alat</th>
    <th>Total Stok</th>
    <th>Aksi</th>
  </tr>

<?php
$q = mysqli_query($conn,"
  SELECT 
    alat.id,
    alat.nama_alat,
    SUM(alat_varian.stok) AS total_stok
  FROM alat
  LEFT JOIN alat_varian ON alat.id = alat_varian.alat_id
  GROUP BY alat.id
");

$no = 1;
while($a = mysqli_fetch_assoc($q)){
?>
  <tr>
    <td><?= $no++; ?></td>
    <td><?= $a['nama_alat']; ?></td>
    <td><?= $a['total_stok'] ?? 0; ?></td>
    <td>
      <a href="varian.php?id=<?= $a['id']; ?>">Kelola Varian</a>
    </td>
  </tr>
<?php } ?>
</table>

</body>
</html>
