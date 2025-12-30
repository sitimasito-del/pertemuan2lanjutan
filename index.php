<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>OUTTREN - Peminjaman Alat Mendaki</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav>
  <img src="img/logo.png">
  <b>OUTTREN</b>
  <a href="#keuntungan">Keuntungan</a>
  <a href="#pricelist">Price List</a>
  <a href="#aturan">Aturan</a>
  <a href="peminjaman.php">Ajukan Peminjaman</a>
  <a href="login.php">admin</a>

</nav>

<!-- ================= HERO VIDEO ================= -->
<section class="hero">
  <video class="bg-video" autoplay muted loop playsinline>
    <source src="video/bg.mp4" type="video/mp4">
  </video>

  <div class="hero-content">
    <h1>OUTTREN</h1>
    <p>Peminjaman Alat Mendaki • Aman • Nyaman • Terpercaya</p>
    <br>
    <a href="peminjaman.php" class="cta-btn">Ajukan Peminjaman</a>
  </div>
</section>

<!-- ================= RUNNING TEXT ================= -->
<div class="running-text">
  <p>🌄 OUTTREN • Peminjaman Alat Mendaki • Aman • Nyaman • Terpercaya •</p>
</div>

<!-- ================= KEUNTUNGAN ================= -->
<section id="keuntungan">
  <h2>Kenapa Memilih OUTTREN?</h2>

  <div class="card">
    <h3>✅ Praktis</h3>
    <p>Pemesanan alat dilakukan secara online tanpa harus datang langsung.</p>
  </div>

  <div class="card">
    <h3>🛡️ Terpercaya</h3>
    <p>Seluruh alat dicek dan dirawat secara berkala.</p>
  </div>

  <div class="card">
    <h3>💸 Terjangkau</h3>
    <p>Harga sewa ramah mahasiswa dan pendaki pemula.</p>
  </div>

  <div class="card">
    <h3>📞 Admin Responsif</h3>
    <p>Konfirmasi peminjaman dan pembayaran via WhatsApp.</p>
  </div>
</section>

<!-- ================= PRICE LIST ================= -->
<section id="pricelist">
  <h2>Price List Alat Mendaki</h2>

  <div class="pricelist">
    <?php
    $alat = mysqli_query($conn,"SELECT * FROM alat");
    while($a = mysqli_fetch_assoc($alat)){

      // ambil harga min & max dari varian
      $harga = mysqli_fetch_assoc(
        mysqli_query($conn,"
          SELECT MIN(harga) AS min_harga, MAX(harga) AS max_harga
          FROM alat_varian
          WHERE alat_id = '".$a['id']."'
        ")
      );
    ?>
      <div class="price-item">
        <div class="price-left">
          <h3><?= $a['nama_alat']; ?></h3>
          <p>Harga sewa per hari</p>
        </div>
        <div class="price-right">
          Rp
          <?php
          if($harga['min_harga'] == $harga['max_harga']){
            echo number_format($harga['min_harga']);
          }else{
            echo number_format($harga['min_harga'])." - ".number_format($harga['max_harga']);
          }
          ?>
        </div>
      </div>
    <?php } ?>
  </div>

  <div style="text-align:center; margin-top:30px;">
    <a href="peminjaman.php" class="cta-btn">Lanjut ke Peminjaman</a>
  </div>
</section>

<!-- ================= TATA TERTIB ================= -->
<section id="aturan">
  <h2>Tata Tertib Peminjaman</h2>
  <ul>
    <li>Peminjam wajib menyerahkan identitas (KTP/KTM).</li>
    <li>Masa peminjaman sesuai tanggal yang disepakati.</li>
    <li>Denda keterlambatan Rp10.000 per hari.</li>
    <li>Kerusakan atau kehilangan alat menjadi tanggung jawab peminjam.</li>
    <li>Alat tidak boleh dipindahtangankan.</li>
  </ul>
</section>

<!-- ================= FOOTER ================= -->
<footer>
  <p><b>OUTTREN</b> — Peminjaman Alat Mendaki</p>
  <p>Ajukan peminjaman melalui website resmi kami</p>
  <p>&copy; <?= date('Y'); ?> OUTTREN</p>
</footer>

</body>
</html>