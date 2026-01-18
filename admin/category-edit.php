<?php
require_once '../config/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    redirect(ADMIN_URL . '/login.php');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get category
$stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch();

if (!$category) {
    $_SESSION['error'] = 'القسم غير موجود';
    redirect(ADMIN_URL . '/categories.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_en = sanitize($_POST['name_en']);
    $name_ar = sanitize($_POST['name_ar']);
    $description_en = $_POST['description_en'];
    $description_ar = $_POST['description_ar'];
    $display_order = (int)$_POST['display_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $slug = generateSlug($name_en);
    
    // Handle image upload
    $image = $category['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $new_image = uploadImage($_FILES['image'], CATEGORIES_UPLOAD_PATH, 'cat_');
        if ($new_image) {
            // Delete old image
            if ($image) {
                deleteImage(CATEGORIES_UPLOAD_PATH . '/' . $image);
            }
            $image = $new_image;
        }
    }
    
    try {
        $stmt = $db->prepare("
            UPDATE categories 
            SET name_en = ?, name_ar = ?, slug = ?, description_en = ?, description_ar = ?, 
                image = ?, display_order = ?, is_active = ?
            WHERE id = ?
        ");
        $stmt->execute([$name_en, $name_ar, $slug, $description_en, $description_ar, $image, $display_order, $is_active, $id]);
        
        $_SESSION['success'] = 'تم تحديث القسم بنجاح';
        redirect(ADMIN_URL . '/categories.php');
    } catch (Exception $e) {
        $error = 'حدث خطأ أثناء تحديث القسم';
    }
}

require_once 'includes/header.php';
?>

<div class="dashboard-content">
    <div class="page-header">
        <h1>تعديل القسم: <?= $category['name_en'] ?></h1>
        <a href="categories.php" class="btn-outline">← العودة للقائمة</a>
    </div>
    
    <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <div class="form-card">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                    <label>الاسم بالإنجليزية *</label>
                    <input type="text" name="name_en" value="<?= htmlspecialchars($category['name_en']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>الاسم بالعربية</label>
                    <input type="text" name="name_ar" value="<?= htmlspecialchars($category['name_ar']) ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>الوصف بالإنجليزية</label>
                    <textarea name="description_en" rows="4"><?= htmlspecialchars($category['description_en']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>الوصف بالعربية</label>
                    <textarea name="description_ar" rows="4"><?= htmlspecialchars($category['description_ar']) ?></textarea>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>صورة القسم</label>
                    <?php if ($category['image']): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="<?= UPLOAD_URL ?>/categories/<?= $category['image'] ?>" 
                             style="max-width: 200px; border: 2px solid #D4AF37; border-radius: 8px;">
                    </div>
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/*">
                    <small>الحد الأقصى: 5MB - اترك فارغاً للإبقاء على الصورة الحالية</small>
                </div>
                
                <div class="form-group">
                    <label>ترتيب العرض</label>
                    <input type="number" name="display_order" value="<?= $category['display_order'] ?>" min="0">
                </div>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" <?= $category['is_active'] ? 'checked' : '' ?>>
                    <span>تفعيل القسم</span>
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-gold">حفظ التعديلات</button>
                <a href="categories.php" class="btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>