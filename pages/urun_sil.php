<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// GET ile gelen id kontrolü
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Geçersiz ID.";
    exit;
}

$id = (int) $_GET['id'];

// Silme işlemi
$stmt = $pdo->prepare("DELETE FROM urunler WHERE id = ?");
$basari = $stmt->execute([$id]);

// Silme başarılıysa yönlendir
if ($basari) {
    header("Location: urun.php");
    exit;
} else {
    echo "Silme işlemi başarısız.";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Ürün Güncelle</title>
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
        <a href="../logout.php">Çıkış Yap</a>
      </div>
    </div>
  </div>
</header>


    <section class="dashboard">
      <h1>Ürün Güncelle</h1>
      <form method="post" class="card" style="max-width: 400px;">
        <label>Ürün Adı</label>
        <input type="text" name="urun_adi" value="<?= htmlspecialchars($urun['urun_adi']) ?>" required class="nav-link">
        <label>Barkod</label>
        <input type="text" name="barkod" value="<?= htmlspecialchars($urun['barkod']) ?>" required class="nav-link">
        <label>Miktar</label>
        <input type="number" name="miktar" value="<?= $urun['miktar'] ?>" required class="nav-link">
        <label>Fiyat</label>
        <input type="number" step="0.01" name="fiyat" value="<?= $urun['fiyat'] ?>" required class="nav-link">
        <br>
        <button type="submit" class="nav-link" style="width:100%; margin-top:10px;">Güncelle</button>
      </form>
    </section>
  </main>
</div>
<script>
function toggleProfileMenu() {
    const menu = document.getElementById("profileMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

window.addEventListener("click", function(e) {
    const menu = document.getElementById("profileMenu");
    const button = document.querySelector(".profile-btn");

    if (!menu.contains(e.target) && !button.contains(e.target)) {
        menu.style.display = "none";
    }
});
</script>
</body>
</html>
