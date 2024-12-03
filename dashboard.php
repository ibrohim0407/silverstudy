<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Dashboard</h2>
    <p>Dashboard sahifasidasiz.</p>
    <a href="logout.php">Chiqish</a>
</body>
</html>
