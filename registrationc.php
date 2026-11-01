<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('P1_contact.html');
}
verify_csrf();
$name = trim((string)($_POST['fullname'] ?? ''));
$email = strtolower(trim((string)($_POST['email'] ?? '')));
$message = trim((string)($_POST['message'] ?? ''));

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '' || mb_strlen($message) > 5000) {
    flash('Please provide your name, a valid email address, and a message (up to 5,000 characters).', 'error');
    redirect('P1_contact.html');
}

try {
    $stmt = $pdo->prepare('INSERT INTO contacts (fullname, email, message) VALUES (:name, :email, :message)');
    $stmt->execute(['name' => $name, 'email' => $email, 'message' => $message]);
    flash('Your message has been sent successfully.');
} catch (Throwable $exception) {
    error_log('R.O.S MATE contact submission failed: ' . $exception->getMessage());
    flash('We could not send your message right now. Please try again.', 'error');
}
redirect('P1_contact.html');
