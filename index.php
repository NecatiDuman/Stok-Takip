<?php
require 'includes/db.php';
session_start();

// İsteğe bağlı: sadece giriş yapmış kullanıcı görsün
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM urunler ORDER BY id DESC");
$urunler = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WMS - Genel Bakış</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <h2 class="logo">WMS</h2>
      <nav class="nav">
        <a href="index.php" class="nav-link active"><i class="fa-solid fa-house"></i> Genel Bakış</a>
        <a href="pages/urun.php" class="nav-link"><i class="fas fa-tags"></i> Ürün Yönetimi</a>
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
        <a href="logout.php">Çıkış Yap</a>
      </div>
    </div>
  </div>
</header>






      <section class="dashboard">
        <h1>Stok Listesi</h1>
        <div class="table-area">
          <table>
            <thead>
              <tr>
                <th>Ürün Adı</th>
                <th>Barkod</th>
                <th>Miktar</th>
                <th>Fiyat</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($urunler as $urun): ?>
                <tr>
                  <td><?= htmlspecialchars($urun['urun_adi']) ?></td>
                  <td><?= htmlspecialchars($urun['barkod']) ?></td>
                  <td><?= $urun['miktar'] ?></td>
                  <td><?= $urun['fiyat'] ?> ₺</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
<script>
function toggleProfileMenu() {
    const menu = document.getElementById("profileMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

// Sayfanın başka yerine tıklanınca menüyü kapat
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
