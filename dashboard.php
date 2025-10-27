<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "tools_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("DB connection failed: ".$conn->connect_error);

$result = $conn->query("SELECT id, email, created_at FROM subscribers ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Subscribers Dashboard</title>
<style>
body { font-family: Arial,sans-serif; background:#111; color:#fff; padding:20px; }
h1 { color:#3DB5FF; }
table { width:100%; border-collapse: collapse; margin-top:20px; }
th, td { padding:10px; border:1px solid #444; text-align:left; }
th { background:#3DB5FF; color:#000; }
tr:nth-child(even) { background:#222; }
</style>
</head>
<body>
<h1>Subscribers</h1>
<?php if ($result->num_rows > 0): ?>
<table>
<tr><th>#</th><th>Email</th><th>Date</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= $row['created_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No subscribers yet.</p>
<?php endif; ?>
</body>
</html>
