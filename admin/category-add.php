<?php
require_once '../config/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    redirect(ADMIN_URL . '/login.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_en = sanitize($_POST['name_en']);
    $name_ar = sanitize($_POST['name_ar']);
    $description_en = $_POST['description_en'];
    $description_ar = $_POST['description_ar'];
    $display_order = (int)$_POST['display_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Generate slug
    $slug = generateSlug($name_en);
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = uploadImage($_FILES['image'], CATEGORIES_UPLOAD_PATH, 'cat_');
    }
    
    try {
        $stmt = $db->prepare("
            INSERT INTO categories (name_en, name_ar, slug, description_en, description_ar, image, display_order, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name_en, $name_ar, $slug, $description_en, $description_ar, $image, $display_order, $is_active]);
        
        $_SESSION['success'] = 'تم إضافة القسم بنجاح';
        redirect(ADMIN_URL . '/categories.php');
    } catch (Exception $e) {
        $error = 'حدث خطأ أثناء إضافة القسم';
    }
}

require_once 'includes/header.php';
?>

<div class="dashboard-content">
    <div class="page-header">
        <h1>إضافة قسم جديد</h1>
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
                    <input type="text" name="name_en" required placeholder="Category Name">
                </div>
                
                <div class="form-group">
                    <label>الاسم بالعربية</label>
                    <input type="text" name="name_ar" placeholder="اسم القسم">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>الوصف بالإنجليزية</label>
                    <textarea name="description_en" rows="4" placeholder="Category description in English"></textarea>
                </div>
                
                <div class="form-group">
                    <label>الوصف بالعربية</label>
                    <textarea name="description_ar" rows="4" placeholder="وصف القسم بالعربية"></textarea>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>صورة القسم</label>
                    <input type="file" name="image" accept="image/*">
                    <small>الحد الأقصى: 5MB - الصيغ المدعومة: JPG, PNG, WEBP</small>
                </div>
                
                <div class="form-group">
                    <label>ترتيب العرض</label>
                    <input type="number" name="display_order" value="0" min="0">
                    <small>الأقل يظهر أولاً</small>
                </div>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" checked>
                    <span>تفعيل القسم</span>
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-gold">حفظ القسم</button>
                <a href="categories.php" class="btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>