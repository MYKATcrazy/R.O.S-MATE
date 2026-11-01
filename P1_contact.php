<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
$notice = take_flash();
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Contact | R.O.S MATE</title><link rel="stylesheet" href="contact.css">
<style>.contact-form{max-width:620px;margin:2rem auto;padding:1.5rem;background:#f4f4f4;border-radius:12px;color:#17212b}.contact-form label{display:block;margin:.8rem 0 .3rem}.contact-form input,.contact-form textarea{box-sizing:border-box;width:100%;padding:.8rem;border:1px solid #aaa;border-radius:6px}.contact-form button{margin-top:1rem;padding:.8rem 1.3rem;border:0;border-radius:6px;background:#00b89c;font-weight:bold;cursor:pointer}.notice{max-width:620px;margin:1rem auto;padding:.8rem;background:#d9f7e9;border-radius:8px}</style></head><body>
<header><div class="container"><h1><img src="mykat%20logo.png" alt="" style="width:5%;height:5%"> R.O.S MATE</h1><nav><ul><li><a href="index.php">Home</a></li><li><a href="SHOPPING.html">Shop</a></li><li><a href="about_us.html">About us</a></li><li><a href="P1_contact.php">Contact</a></li></ul></nav></div></header>
<section class="contact"><div class="container"><h2>Contact Us</h2><p>Phone: 7892501771 · Email: crazymykat@gmail.com</p>
<?php if ($notice): ?><p class="notice"><?= e($notice['message']) ?></p><?php endif; ?>
<form class="contact-form" action="registrationc.php" method="post">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label for="fullname">Full name</label><input id="fullname" name="fullname" maxlength="128" required>
<label for="email">Email</label><input id="email" type="email" name="email" maxlength="255" required>
<label for="message">Message</label><textarea id="message" name="message" rows="5" maxlength="5000" required></textarea>
<button type="submit">Send message</button></form></div></section>
<footer><div class="container"><p>&copy; <?= date('Y') ?> R.O.S MATE. All rights reserved.</p></div></footer></body></html>
