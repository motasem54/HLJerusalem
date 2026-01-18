<?php
require_once '../config/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    redirect(ADMIN_URL . '/login.php');
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'تم حذف المنتج بنجاح';
    redirect(ADMIN_URL . '/products.php');
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = ADMIN_ITEMS_PER_PAGE;
$offset = ($page - 1) * $per_page;

// Get total
$total = $db->query("SELECT COUNT(*) as count FROM products")->fetch()['count'];
$total_pages = ceil($total / $per_page);

// Get products
$stmt = $db->query("
    SELECT p.*, c.name_en as category_name, c.name_ar as category_name_ar
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.created_at DESC
    LIMIT $per_page OFFSET $offset
");
$products = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<div class="dashboard-content">
    <div class="page-header">
        <h1>إدارة المنتجات</h1>
        <a href="product-add.php" class="btn-gold">+ إضافة منتج جديد</a>
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
                    <th>الاسم</th>
                    <th>القسم</th>
                    <th>النوع</th>
                    <th>اللون</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?php if ($product['main_image']): ?>
                            <img src="<?= UPLOAD_URL ?>/products/<?= $product['main_image'] ?>" 
                                 alt="<?= $product['name_en'] ?>" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        <?php else: ?>
                            <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                🏛️
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= $product['name_en'] ?></strong>
                        <?php if ($product['name_ar']): ?>
                        <br><small style="color: #999;"><?= $product['name_ar'] ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?= $product['category_name'] ?></td>
                    <td>
                        <span class="badge badge-info"><?= str_replace('_', ' ', $product['product_type']) ?></span>
                    </td>
                    <td><?= $product['color'] ?: '-' ?></td>
                    <td>
                        <span class="badge <?= $product['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                            <?= $product['is_active'] ? 'نشط' : 'غير نشط' ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="product-edit.php?id=<?= $product['id'] ?>" class="btn-sm btn-primary">تعديل</a>
                            <a href="?delete=<?= $product['id'] ?>" 
                               class="btn-sm btn-danger" 
                               onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">حذف</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>