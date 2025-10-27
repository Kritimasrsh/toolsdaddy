<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address!";
        exit;
    }

    // File to store emails
    $file = 'emails.txt';
    if (!file_exists($file)) file_put_contents($file, '');

    // Prevent duplicates
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($email, $emails)) {
        echo "You're already on the list!";
        exit;
    }

    // Store email
    file_put_contents($file, $email . PHP_EOL, FILE_APPEND | LOCK_EX);
    echo "Thank you! You'll be notified.";
} else {
    echo "Invalid request!";
}
?>
