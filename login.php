<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/db.php';

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = "Kullanıcı adı veya şifre hatalı!";
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Giriş Yap - WMS</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            background-color: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: var(--card-bg);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

            .login-container h2 {
                margin-bottom: 1.5rem;
                color: var(--accent);
            }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                color: var(--text-light);
            }

            .form-group input {
                width: 100%;
                padding: 0.75rem;
                border-radius: 8px;
                border: none;
                background-color: var(--bg-light);
                color: var(--text-light);
            }

                .form-group input:focus {
                    outline: 2px solid var(--accent);
                }

        .login-btn {
            margin-top: 1rem;
            width: 100%;
            padding: 0.75rem;
            background-color: var(--accent);
            color: #000;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

            .login-btn:hover {
                background-color: #ff8787;
            }

        .error-message {
            color: #ff6b6b;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>WMS Giriş</h2>
        <?php if (!empty($_SESSION['error'])): ?>
        <p class="error-message"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form id="loginForm" action="login.php" method="POST">
          <div class="form-group">
    <label for="username">Kullanıcı Adı</label>
    <input type="text" id="username" name="username" required />
</div>
<div class="form-group">
    <label for="password">Şifre</label>
    <input type="password" id="password" name="password" required />
</div>
<button type="submit" class="login-btn">Giriş Yap</button>
        </form>
    </div>


</body>
</html>