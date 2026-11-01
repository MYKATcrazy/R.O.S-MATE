<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

if (!empty($_SESSION['user_id'])) {
    redirect('dashboard.php');
}
$errors = [];
$fullName = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $fullName = trim((string)($_POST['fullname'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    $repeat = (string)($_POST['repeat_password'] ?? '');

    if ($fullName === '' || mb_strlen($fullName) > 128) $errors[] = 'Enter your name (maximum 128 characters).';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) $errors[] = 'Enter a valid email address.';
    if (strlen($password) < 8) $errors[] = 'Password must contain at least 8 characters.';
    if ($password !== $repeat) $errors[] = 'The passwords do not match.';

    if (!$errors) {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password) VALUES (:name, :email, :password)');
            $stmt->execute([
                'name' => $fullName,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
            flash('Account created. You can now sign in.');
            redirect('login.php');
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000' || str_contains(strtolower($exception->getMessage()), 'unique')) {
                $errors[] = 'An account with that email already exists.';
            } else {
                error_log('R.O.S MATE registration failed: ' . $exception->getMessage());
                $errors[] = 'Registration is temporarily unavailable. Please try again.';
            }
        }
    }
}
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Create account | R.O.S MATE</title>
<style>
body{min-height:100vh;display:grid;place-items:center;background:#101820;color:#f5f5f5;font-family:Arial,sans-serif}
.auth{width:min(92vw,430px);padding:2rem;background:#1b2732;border-radius:16px;box-shadow:0 15px 45px #0006}
.auth img{width:76px;height:76px;object-fit:contain}.auth input{box-sizing:border-box;width:100%;padding:.85rem;margin:.35rem 0 1rem;border:1px solid #526170;border-radius:8px;background:#0f1820;color:white}
.auth label{display:block}.auth button{width:100%;padding:.9rem;border:0;border-radius:8px;background:#00d1b2;font-weight:700;cursor:pointer}
.auth a{color:#00d1b2}.error{padding:.7rem;background:#6c2630;border-radius:8px}
</style></head><body><main class="auth">
<img src="mykat%20logo.png" alt="R.O.S MATE logo"><h1>Join R.O.S MATE</h1>
<?php foreach ($errors as $error): ?><p class="error"><?= e($error) ?></p><?php endforeach; ?>
<form method="post" action="registration.php">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label for="fullname">Full name</label><input id="fullname" name="fullname" maxlength="128" autocomplete="name" required value="<?= e($fullName) ?>">
<label for="email">Email</label><input id="email" type="email" name="email" maxlength="255" autocomplete="email" required value="<?= e($email) ?>">
<label for="password">Password (8+ characters)</label><input id="password" type="password" name="password" minlength="8" autocomplete="new-password" required>
<label for="repeat_password">Confirm password</label><input id="repeat_password" type="password" name="repeat_password" minlength="8" autocomplete="new-password" required>
<button type="submit">Create account</button></form>
<p>Already registered? <a href="login.php">Login</a></p><p><a href="index.php">Back to home</a></p>
</main></body></html>
