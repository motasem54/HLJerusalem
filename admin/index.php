<?php
require_once '../config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$admin = $_SESSION['admin_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - H.L. Jerusalem</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <h2>H.L. JERUSALEM</h2>
                <p>Admin Panel</p>
            </div>
            
            <nav class="admin-nav">
                <a href="index.php" class="active">
                    <span>☷</span> Dashboard
                </a>
                <a href="categories.php">
                    <span>▦</span> Categories
                </a>
                <a href="products.php">
                    <span>◆</span> Products
                </a>
                <a href="projects.php">
                    <span>✦</span> Projects
                </a>
                <a href="settings.php">
                    <span>⚙</span> Settings
                </a>
                <a href="logout.php" style="margin-top: auto;">
                    <span>✗</span> Logout
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1>Dashboard</h1>
                <div class="admin-user">
                    <span>Welcome, <?php echo htmlspecialchars($admin['full_name']); ?></span>
                </div>
            </header>
            
            <div class="admin-content">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <?php
                    // Get statistics
                    $categories_count = $pdo->query("SELECT COUNT(*) FROM categories WHERE is_active = 1")->fetchColumn();
                    $products_count = $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1")->fetchColumn();
                    $projects_count = $pdo->query("SELECT COUNT(*) FROM projects WHERE is_active = 1")->fetchColumn();
                    ?>
                    
                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--primary-gold);">▦</div>
                        <div class="stat-info">
                            <h3><?php echo $categories_count; ?></h3>
                            <p>Categories</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--secondary-brown);">◆</div>
                        <div class="stat-info">
                            <h3><?php echo $products_count; ?></h3>
                            <p>Products</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--primary-brown);">✦</div>
                        <div class="stat-info">
                            <h3><?php echo $projects_count; ?></h3>
                            <p>Projects</p>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h2>Quick Actions</h2>
                    <div class="actions-grid">
                        <a href="categories.php?action=add" class="action-btn">
                            <span>+</span>
                            <p>Add Category</p>
                        </a>
                        <a href="products.php?action=add" class="action-btn">
                            <span>+</span>
                            <p>Add Product</p>
                        </a>
                        <a href="projects.php?action=add" class="action-btn">
                            <span>+</span>
                            <p>Add Project</p>
                        </a>
                        <a href="../index.php" target="_blank" class="action-btn">
                            <span>👁</span>
                            <p>View Website</p>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>