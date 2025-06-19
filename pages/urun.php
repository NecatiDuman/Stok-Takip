<?php
require '../includes/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$arama = $_GET['q'] ?? '';
$query = "SELECT * FROM urunler WHERE urun_adi LIKE ? OR barkod LIKE ?";
$stmt = $pdo->prepare($query);
$stmt->execute(["%$arama%", "%$arama%"]);
$urunler = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ürün Yönetimi</title>
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
<div class="container">
  <aside class="sidebar">
    <h2 class="logo">WMS</h2>
    <nav class="nav">
      
      <a href="../index.php" class="nav-link"><i class="fa-solid fa-house"></i> Genel Bakış</a>
      <a href="urunler.php" class="nav-link active"><i class="fas fa-tags"></i> Ürün Yönetimi</a>
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
      <h1>Ürünler</h1>
      <form method="get" style="margin-bottom: 1rem;">
        <input type="text" name="q" placeholder="Ürün adı veya barkod ara" value="<?= htmlspecialchars($arama) ?>" style="padding:0.5rem; border-radius:8px; border:none; width:200px;">
        <button type="submit" class="nav-link" style="display:inline-block; width:auto; margin-left: 10px;">Ara</button>
        <a href="urun_ekle.php" class="nav-link" style="display:inline-block; width:auto;">+ Yeni Ürün</a>
      </form>

      <div class="table-area">
        <table>
          <thead>
            <tr>
              <th>Ürün Adı</th>
              <th>Barkod</th>
              <th>Miktar</th>
              <th>Fiyat (₺)</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($urunler as $urun): ?>
              <tr>
                <td><?= htmlspecialchars($urun['urun_adi']) ?></td>
                <td><?= htmlspecialchars($urun['barkod']) ?></td>
                <td><?= $urun['miktar'] ?></td>
                <td><?= $urun['fiyat'] ?></td>
                <td>
                  <a href="urun_duzenle.php?id=<?= $urun['id'] ?>">✏️</a>
                  <a href="urun_sil.php?id=<?= $urun['id'] ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">🗑️</a>
                </td>
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
