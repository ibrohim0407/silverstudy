<?php
$host = 'localhost';
$user = 'root'; // MySQL foydalanuvchi nomi
$password = ''; // MySQL parol (agar mavjud bo'lsa)
$dbname = 'school';

// Bazaga ulanish
$conn = new mysqli($host, $user, $password, $dbname);

// Xatolik yuz bersa
if ($conn->connect_error) {
    die("Ulanishda xatolik: " . $conn->connect_error);
}
?>
