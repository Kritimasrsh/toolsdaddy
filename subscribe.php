<?php
header('Content-Type: text/plain');

$servername = "localhost";
$username = "root";  // your DB username
$password = "";      // your DB password
$dbname = "tools_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email!";
        exit;
    }

    // Check for duplicates
    $stmt = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "You're already on the list! ✅";
    } else {
        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            echo "Thank you! You'll be notified! ✅";
        } else {
            echo "Database error!";
        }
    }
}
$conn->close();
?>
