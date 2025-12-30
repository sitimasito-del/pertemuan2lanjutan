<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Peminjaman OUTTREN</title>
  <style>
    body{
      font-family: Arial, sans-serif;
      background:#f2f2f2;
      margin:0;
      padding:30px;
    }
    .box{
      max-width:700px;
      margin:auto;
      background:white;
      padding:25px;
      border-radius:12px;
      box-shadow:0 10px 25px rgba(0,0,0,.2);
    }
    h2,h3{color:#1b4332}
    input,select,button{
      width:100%;
      padding:10px;
      margin-bottom:10px;
    }
    button{
      background:#1b4332;
      color:white;
      border:none;
      border-radius:20px;
      cursor:pointer;
    }
    button:hover{background:#2d6a4f}
    hr{margin:15px 0}
  </style>
</head>
<body>

<div class="box">
<h2>Form Peminjaman Alat Mendaki</h2>

<form method="POST">

<h3>Data Peminjam</h3>
<input type="text" name="nama" placeholder="Nama Lengkap" required>
<input type="text" name="wa" placeholder="No WhatsApp Aktif" required>

<h3>Pilih Alat & Varian</h3>

<?php
$alat = mysqli_query($conn,"SELECT * FROM alat");
while($a = mysqli_fetch_assoc($alat)){
  echo "<b>".$a['nama_alat']."</b><br>";

  $var = mysqli_query($conn,"
    SELECT * FROM alat_varian 
    WHERE alat_id='".$a['id']."' AND stok > 0
  ");
  while($v = mysqli_fetch_assoc($var)){
    echo "
    <label>
      <input type='checkbox' name='varian_id[]' value='".$v['id']."'>
      ".$v['varian']." (Rp".number_format($v['harga'])."/hari | Stok: ".$v['stok'].")
    </label><br>";
  }
  echo "<hr>";
}
?>

<h3>Jaminan</h3>
<select name="jaminan" required>
  <option value="">-- Pilih Jaminan --</option>
  <option value="KTP">KTP</option>
  <option value="KTM">KTM</option>
  <option value="SIM">SIM</option>
</select>

<h3>Waktu Peminjaman</h3>
<label>Tanggal Pinjam</label>
<input type="date" name="pinjam" required>

<label>Tanggal Kembali</label>
<input type="date" name="kembali" required>

<button name="simpan">Proses Peminjaman</button>
</form>

<?php
// ================= PROSES SIMPAN =================
if(isset($_POST['simpan'])){

  $nama    = $_POST['nama'];
  $wa      = $_POST['wa'];
  $pinjam  = $_POST['pinjam'];
  $kembali = $_POST['kembali'];
  $jaminan = $_POST['jaminan'];

  if(!isset($_POST['varian_id'])){
    die("<p style='color:red'>Pilih minimal 1 alat</p>");
  }

  // hitung hari
  $tgl1 = new DateTime($pinjam);
  $tgl2 = new DateTime($kembali);
  $hari = $tgl1->diff($tgl2)->days;
  if($hari < 1){ $hari = 1; }

  // INSERT HEADER PEMINJAMAN
  mysqli_query($conn,"
    INSERT INTO peminjaman
    (nama, whatsapp, tgl_pinjam, tgl_kembali, jaminan, status)
    VALUES
    ('$nama','$wa','$pinjam','$kembali','$jaminan','baru')
  ");

  $id_peminjaman = mysqli_insert_id($conn);
  $total = 0;

  // INSERT DETAIL
  foreach($_POST['varian_id'] as $vid){

    $q = mysqli_query($conn,"
      SELECT harga FROM alat_varian WHERE id='$vid'
    ");
    $v = mysqli_fetch_assoc($q);

    $subtotal = $v['harga'] * $hari;
    $total += $subtotal;

    mysqli_query($conn,"
      INSERT INTO peminjaman_detail
      (peminjaman_id, alat_varian_id, harga)
      VALUES
      ('$id_peminjaman','$vid','{$v['harga']}')
    ");
  }

  echo "
  <hr>
  <h3 style='color:green'>Peminjaman Berhasil</h3>
  Nama: <b>$nama</b><br>
  Durasi: <b>$hari hari</b><br>
  Total Bayar: <b>Rp".number_format($total)."</b>
  ";
}
?>

</div>
</body>
</html>