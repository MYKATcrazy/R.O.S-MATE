<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
$member = !empty($_SESSION['user_id']);
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>R.O.S MATE | Skateboard community</title><link rel="stylesheet" href="styles.css">
<style>
.auth-links{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;margin:1.5rem auto}
.auth-links a{display:inline-block;padding:.7rem 1.2rem;border-radius:7px;background:#00d1b2;color:#071015;text-decoration:none;font-weight:700}
.auth-links a.secondary{background:transparent;color:inherit;border:1px solid currentColor}
</style></head><body>
<header><div class="container"><h1>R.O.S MATE</h1><nav><ul>
<li><a href="index.php">Home</a></li><li><a href="SHOPPING.html">Shop</a></li><li><a href="about_us.html">About us</a></li><li><a href="P1_contact.html">Contact</a></li>
</ul></nav></div></header>
<section class="hero"><div class="container"><h2>Welcome to R.O.S MATE</h2>
<p>A community for skateboarders to connect, learn, ride, and find their next board.</p>
<div class="auth-links"><a href="products.html">Explore skateboards</a>
<?php if ($member): ?><a class="secondary" href="dashboard.php">Member dashboard</a><?php else: ?><a class="secondary" href="login.php">Member login</a><a class="secondary" href="registration.php">Create account</a><?php endif; ?>
</div></div></section>
<section class="features"><div class="container"><h2>Ride together</h2><div class="feature"><h3>Find your board</h3><p>Browse the skateboard collection and contact us to place an order.</p></div><div class="feature"><h3>Join the community</h3><p>Create an account to access your member area.</p></div><div class="feature"><h3>Get in touch</h3><p>Questions or feedback? Send the R.O.S MATE team a message.</p></div></div></section>
<footer><div class="container"><p>&copy; <?= date('Y') ?> R.O.S MATE. All rights reserved.</p></div></footer>
</body></html>
