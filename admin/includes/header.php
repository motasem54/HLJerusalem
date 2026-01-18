<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - H.L. Jerusalem</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="<?= BASE_URL ?>/assets/images/logo.png" alt="Logo" class="sidebar-logo">
                <h2>H.L. JERUSALEM</h2>
                <p>لوحة التحكم</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                    <span class="nav-icon">🏠</span>
                    <span>الرئيسية</span>
                </a>
                
                <a href="categories.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : '' ?>">
                    <span class="nav-icon">📦</span>
                    <span>أقسام الرخام</span>
                </a>
                
                <a href="products.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : '' ?>">
                    <span class="nav-icon">🏛️</span>
                    <span>المنتجات</span>
                </a>
                
                <a href="projects.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'active' : '' ?>">
                    <span class="nav-icon">🏗️</span>
                    <span>المشاريع</span>
                </a>
                
                <a href="messages.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : '' ?>">
                    <span class="nav-icon">✉️</span>
                    <span>الرسائل</span>
                </a>
                
                <a href="settings.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                    <span class="nav-icon">⚙️</span>
                    <span>الإعدادات</span>
                </a>
                
                <div class="nav-divider"></div>
                
                <a href="<?= BASE_URL ?>" target="_blank" class="nav-item">
                    <span class="nav-icon">🌐</span>
                    <span>زيارة الموقع</span>
                </a>
                
                <a href="logout.php" class="nav-item">
                    <span class="nav-icon">🚪</span>
                    <span>تسجيل الخروج</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <p>مستخدم: <?= $_SESSION['admin_name'] ?></p>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">