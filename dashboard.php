<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Member dashboard | R.O.S MATE</title>
<style>body{margin:0;background:#101820;color:#f5f5f5;font:16px Arial,sans-serif}.wrap{max-width:900px;margin:8vh auto;padding:2rem;background:#1b2732;border-radius:16px}a{color:#00d1b2}button{padding:.7rem 1rem;border:0;border-radius:7px;background:#00d1b2;font-weight:bold;cursor:pointer}</style></head><body><main class="wrap">
<h1>Welcome, <?= e((string)($_SESSION['user_name'] ?? 'Member')) ?>.</h1><p>You are signed in to R.O.S MATE.</p>
<p><a href="products.html">Browse skateboards</a> · <a href="P1_contact.html">Contact us</a></p>
<form method="post" action="logout.php"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><button type="submit">Sign out</button></form>
<p><a href="index.php">Return to home</a></p></main></body></html>
