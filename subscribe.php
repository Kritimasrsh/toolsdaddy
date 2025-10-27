<?php
// Database config - update these with your credentials
$host = 'localhost';
$db   = 'tools_db';  // your database name
$user = 'root';      // your database username
$pass = '';          // your database password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Check if already subscribed
    $stmt = $conn->prepare("SELECT id FROM subscribers WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "This email is already subscribed!";
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // Insert new subscriber
    $stmt = $conn->prepare("INSERT INTO subscribers(email) VALUES(?)");
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        echo "Thank you! You have been added to the waitlist.";
    } else {
        echo "Something went wrong. Try again.";
    }
    $stmt->close();
}
$conn->close();
?>
