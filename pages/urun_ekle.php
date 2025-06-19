<?php
require '../includes/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $urun_adi = $_POST['urun_adi'];
    $barkod = $_POST['barkod'];
    $miktar = $_POST['miktar'];
    $fiyat = $_POST['fiyat'];

    $stmt = $pdo->prepare("INSERT INTO urunler (urun_adi, barkod, miktar, fiyat) VALUES (?, ?, ?, ?)");
    $stmt->execute([$urun_adi, $barkod, $miktar, $fiyat]);

    header("Location: urun.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Yeni Ürün Ekle</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
<div class="container">
  <aside class="sidebar">
    <h2 class="logo">WMS</h2>
    <nav class="nav">
      <a href="urun.php" class="nav-link active"><i class="fas fa-tags"></i> Ürün Yönetimi</a>
    </nav>
  </aside>

  <main class="main">
 <header class="topbar">
  <div class="user-info">
    <div class="profile-dropdown">
      <button class="profile-btn" onclick="toggleProfileMenu()">
        <?= htmlspecialchars($_SESSION['username']) ?>
      </button>
      <div class="profile-menu" id="profileMenu" style="display: none;">
        <a href="/wms/logout.php">Çıkış Yap</a>
      </div>
    </div>
  </div>
</header>


    <section class="dashboard">
      <h1>Yeni Ürün Ekle</h1>
      <form method="post" class="card" style="max-width: 400px;">
        <label>Ürün Adı</label>
        <input type="text" name="urun_adi" required class="nav-link">
        <label>Barkod</label>
        <input type="text" name="barkod" required class="nav-link">
        <label>Miktar</label>
        <input type="number" name="miktar" required class="nav-link">
        <label>Fiyat</label>
        <input type="number" step="0.01" name="fiyat" required class="nav-link">
        <br>
        <button type="submit" class="nav-link" style="width:100%; margin-top:10px;">Ekle</button>
      </form>
    </section>
  </main>
</div>
<script>
function toggleProfileMenu() {
  const menu = document.getElementById('profileMenu');
  if (menu.style.display === 'block') {
    menu.style.display = 'none';
  } else {
    menu.style.display = 'block';
  }
}


window.addEventListener('click', function(e) {
  const menu = document.getElementById('profileMenu');
  const btn = document.querySelector('.profile-btn');
  if (!btn.contains(e.target) && !menu.contains(e.target)) {
    menu.style.display = 'none';
  }
});
</script>
</body>
</html>
