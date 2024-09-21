<?php
session_start();

// بيانات الدخول الثابتة
define('ADMIN_EMAIL', 'admin@example.com'); // البريد الإلكتروني
define('ADMIN_PASSWORD', 'password123');    // كلمة المرور

// التحقق من إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // التحقق من صحة البريد الإلكتروني وكلمة المرور
    if ($email === ADMIN_EMAIL && $password === ADMIN_PASSWORD) {
        // تسجيل الدخول بنجاح
        $_SESSION['is_logged_in'] = true;
        header("Location: dashboard.php"); // الانتقال إلى لوحة التحكم
        exit();
    } else {
        $error_message = "البريد الإلكتروني أو كلمة المرور غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>تسجيل الدخول</h2>
    <form method="POST" action="login.php">
        <label for="email">البريد الإلكتروني:</label>
        <input type="email" name="email" required>

        <label for="password">كلمة المرور:</label>
        <input type="password" name="password" required>

        <button type="submit">تسجيل الدخول</button>
    </form>

    <?php if (isset($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>
</html>
