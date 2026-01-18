<?php
require_once '../config/config.php';

if (isset($_SESSION['admin_logged_in'])) {
    redirect(ADMIN_URL . '/index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    
    $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ? AND is_active = 1");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $_SESSION['admin_role'] = $admin['role'];
        
        // Update last login
        $stmt = $db->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$admin['id']]);
        
        redirect(ADMIN_URL . '/index.php');
    } else {
        $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="../assets/images/logo.png" alt="H.L. Jerusalem Logo" class="login-logo">
                <h1>H.L. JERUSALEM</h1>
                <p>لوحة التحكم</p>
            </div>
            
            <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label>اسم المستخدم</label>
                    <input type="text" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-gold btn-block">تسجيل الدخول</button>
            </form>
            
            <div class="login-footer">
                <p>&copy; <?= date('Y') ?> H.L. Jerusalem Stone & Marble</p>
            </div>
        </div>
    </div>
</body>
</html>