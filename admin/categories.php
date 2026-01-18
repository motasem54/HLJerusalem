<?php
require_once '../config/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    redirect(ADMIN_URL . '/login.php');
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'تم حذف القسم بنجاح';
    redirect(ADMIN_URL . '/categories.php');
}

// Get all categories
$stmt = $db->query("SELECT * FROM categories ORDER BY display_order ASC, created_at DESC");
$categories = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<div class="dashboard-content">
    <div class="page-header">
        <h1>إدارة أقسام الرخام والحجر</h1>
        <a href="category-add.php" class="btn-gold">+ إضافة قسم جديد</a>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
    <?php endif; ?>
    
    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>الاسم بالإنجليزية</th>
                    <th>الاسم بالعربية</th>
                    <th>عدد المنتجات</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($categories as $category):
                    // Get products count
                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = ?");
                    $stmt->execute([$category['id']]);
                    $products_count = $stmt->fetch()['count'];
                ?>
                <tr>
                    <td>
                        <?php if ($category['image']): ?>
                            <img src="<?= UPLOAD_URL ?>/categories/<?= $category['image'] ?>" 
                                 alt="<?= $category['name_en'] ?>" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        <?php else: ?>
                            <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                📦
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= $category['name_en'] ?></strong></td>
                    <td><?= $category['name_ar'] ?: '-' ?></td>
                    <td>
                        <span class="badge badge-info"><?= $products_count ?> منتج</span>
                    </td>
                    <td><?= $category['display_order'] ?></td>
                    <td>
                        <span class="badge <?= $category['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                            <?= $category['is_active'] ? 'نشط' : 'غير نشط' ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="category-edit.php?id=<?= $category['id'] ?>" class="btn-sm btn-primary">تعديل</a>
                            <a href="?delete=<?= $category['id'] ?>" 
                               class="btn-sm btn-danger" 
                               onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟');">حذف</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>