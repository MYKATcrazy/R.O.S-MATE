<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

if (!empty($_SESSION['user_id'])) {
    redirect('dashboard.php');
}

$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Enter a valid email address and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, full_name, email, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            unset($_SESSION['csrf_token']);
            redirect('dashboard.php');
        }
        $error = 'Email or password is incorrect.';
    }
}
$notice = take_flash();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login | R.O.S MATE</title><link rel="stylesheet" href="login2.css">
  <style>
    body{min-height:100vh;display:grid;place-items:center;background:#101820;color:#f5f5f5;font-family:Arial,sans-serif}
    .auth{width:min(92vw,430px);padding:2rem;background:#1b2732;border-radius:16px;box-shadow:0 15px 45px #0006}
    .auth img{width:76px;height:76px;object-fit:contain}.auth h1{margin:.5rem 0 1.5rem}
    .auth label{display:block;margin:1rem 0 .35rem}.auth input{box-sizing:border-box;width:100%;padding:.85rem;border:1px solid #526170;border-radius:8px;background:#0f1820;color:white}
    .auth button{width:100%;margin-top:1.2rem;padding:.9rem;border:0;border-radius:8px;background:#00d1b2;color:#071015;font-weight:700;cursor:pointer}
    .auth a{color:#00d1b2}.alert{padding:.8rem;border-radius:8px;background:#6c2630;margin:.8rem 0}
  </style>
</head>
<body><main class="auth">
  <img src="mykat%20logo.png" alt="R.O.S MATE logo"><h1>R.O.S MATE</h1>
  <h2>Sign in</h2>
  <?php if ($error): ?><p class="alert"><?= e($error) ?></p><?php endif; ?>
  <?php if ($notice): ?><p><?= e($notice['message']) ?></p><?php endif; ?>
  <form method="post" action="login.php">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <label for="email">Email</label><input id="email" name="email" type="email" autocomplete="email" required value="<?= e($email) ?>">
    <label for="password">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required>
    <button type="submit">Login</button>
  </form>
  <p>New here? <a href="registration.php">Create an account</a></p><p><a href="index.php">Back to R.O.S MATE</a></p>
</main></body></html>
