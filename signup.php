<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password !== $confirm_password) {
        $error_message = "Parollar mos kelmaydi!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $success_message = "Ro'yxatdan o'tish muvaffaqiyatli amalga oshirildi!";
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ro'yxatdan O'tish</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>

    <div class="container">
        <form class="signup-form" method="POST" action="signup.php">
            <h2>Ro'yxatdan O'tish</h2>
            
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?= $error_message ?></div>
            <?php elseif (isset($success_message)): ?>
                <div class="success-message"><?= $success_message ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="fullname">Ismingiz:</label>
                <input type="text" id="fullname" name="fullname" placeholder="Ismingizni kiriting" required>
            </div>
            
            <div class="form-group">
                <label for="email">Elektron Pochta:</label>
                <input type="email" id="email" name="email" placeholder="Email manzilingizni kiriting" required>
            </div>
            
            <div class="form-group">
                <label for="password">Parol:</label>
                <input type="password" id="password" name="password" placeholder="Parolingizni kiriting" required>
            </div>
            
            <div class="form-group">
                <label for="confirm-password">Parolni Tasdiqlash:</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Parolingizni tasdiqlang" required>
            </div>
            
            <div class="form-group">
                <button type="submit" class="submit-btn">Ro'yxatdan O'tish</button>
            </div>
            
            <p class="login-link">Agar hisobingiz bor bo'lsa, <a href="index.php">kirish</a> qiling.</p>
        </form>
    </div>

</body>
</html>
