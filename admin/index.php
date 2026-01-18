<?php
require_once '../config/config.php';

// Check if logged in
if (!isset($_SESSION['admin_logged_in'])) {
    redirect(ADMIN_URL . '/login.php');
}

require_once 'includes/header.php';

// Get statistics
$stats = [];

$stmt = $db->query("SELECT COUNT(*) as count FROM categories WHERE is_active = 1");
$stats['categories'] = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM products WHERE is_active = 1");
$stats['products'] = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM projects WHERE is_active = 1");
$stats['projects'] = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0");
$stats['messages'] = $stmt->fetch()['count'];
?>

<div class="dashboard-content">
    <div class="page-header">
        <h1>لوحة التحكم الرئيسية</h1>
        <p>مرحباً <?= $_SESSION['admin_name'] ?></p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h3><?= $stats['categories'] ?></h3>
                <p>أقسام الرخام</p>
            </div>
            <a href="categories.php" class="stat-link">عرض الكل</a>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🏛️</div>
            <div class="stat-info">
                <h3><?= $stats['products'] ?></h3>
                <p>المنتجات</p>
            </div>
            <a href="products.php" class="stat-link">عرض الكل</a>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🏗️</div>
            <div class="stat-info">
                <h3><?= $stats['projects'] ?></h3>
                <p>المشاريع</p>
            </div>
            <a href="projects.php" class="stat-link">عرض الكل</a>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">✉️</div>
            <div class="stat-info">
                <h3><?= $stats['messages'] ?></h3>
                <p>رسائل جديدة</p>
            </div>
            <a href="messages.php" class="stat-link">عرض الكل</a>
        </div>
    </div>
    
    <div class="recent-section">
        <h2>آخر المنتجات المضافة</h2>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>القسم</th>
                        <th>النوع</th>
                        <th>تاريخ الإضافة</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->query("
                        SELECT p.*, c.name_ar as category_name 
                        FROM products p 
                        LEFT JOIN categories c ON p.category_id = c.id 
                        ORDER BY p.created_at DESC 
                        LIMIT 5
                    ");
                    $recent_products = $stmt->fetchAll();
                    
                    foreach ($recent_products as $product):
                    ?>
                    <tr>
                        <td><?= $product['name_en'] ?></td>
                        <td><?= $product['category_name'] ?></td>
                        <td><?= $product['product_type'] ?></td>
                        <td><?= date('Y-m-d', strtotime($product['created_at'])) ?></td>
                        <td>
                            <span class="badge <?= $product['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                                <?= $product['is_active'] ? 'نشط' : 'غير نشط' ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>