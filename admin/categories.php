<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
    header('Location: categories.php?msg=deleted');
    exit;
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name_en = $_POST['name_en'];
    $name_ar = $_POST['name_ar'];
    $description_en = $_POST['description_en'];
    $description_ar = $_POST['description_ar'];
    $display_order = (int)$_POST['display_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../uploads/categories/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $image = 'uploads/categories/' . time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
    }
    
    if ($id) {
        // Update
        $sql = "UPDATE categories SET name_en = ?, name_ar = ?, description_en = ?, description_ar = ?, display_order = ?, is_active = ?";
        $params = [$name_en, $name_ar, $description_en, $description_ar, $display_order, $is_active];
        
        if ($image) {
            $sql .= ", image = ?";
            $params[] = $image;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $id;
        
        $pdo->prepare($sql)->execute($params);
        header('Location: categories.php?msg=updated');
    } else {
        // Insert
        $pdo->prepare(
            "INSERT INTO categories (name_en, name_ar, description_en, description_ar, image, display_order, is_active) 
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        )->execute([$name_en, $name_ar, $description_en, $description_ar, $image, $display_order, $is_active]);
        header('Location: categories.php?msg=added');
    }
    exit;
}

// Get all categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY display_order ASC, name_en ASC")->fetchAll();

// Get single category for editing
$edit_category = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_category = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $edit_category->execute([$edit_id]);
    $edit_category = $edit_category->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Categories Management</h1>
            </header>
            
            <div class="admin-content">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success">
                        <?php
                        echo match($_GET['msg']) {
                            'added' => 'Category added successfully!',
                            'updated' => 'Category updated successfully!',
                            'deleted' => 'Category deleted successfully!',
                            default => ''
                        };
                        ?>
                    </div>
                <?php endif; ?>
                
                <!-- Add/Edit Form -->
                <div class="form-container">
                    <h2><?php echo $edit_category ? 'Edit Category' : 'Add New Category'; ?></h2>
                    <form method="POST" enctype="multipart/form-data">
                        <?php if ($edit_category): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_category['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label>Name (English) *</label>
                            <input type="text" name="name_en" value="<?php echo htmlspecialchars($edit_category['name_en'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Name (Arabic)</label>
                            <input type="text" name="name_ar" value="<?php echo htmlspecialchars($edit_category['name_ar'] ?? ''); ?>" dir="rtl">
                        </div>
                        
                        <div class="form-group">
                            <label>Description (English)</label>
                            <textarea name="description_en"><?php echo htmlspecialchars($edit_category['description_en'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Description (Arabic)</label>
                            <textarea name="description_ar" dir="rtl"><?php echo htmlspecialchars($edit_category['description_ar'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" accept="image/*">
                            <?php if ($edit_category && $edit_category['image']): ?>
                                <img src="../<?php echo $edit_category['image']; ?>" style="width: 150px; margin-top: 10px; border-radius: 8px;">
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" name="display_order" value="<?php echo $edit_category['display_order'] ?? 0; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_active" <?php echo (!$edit_category || $edit_category['is_active']) ? 'checked' : ''; ?>>
                                Active
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?php echo $edit_category ? 'Update' : 'Add'; ?> Category</button>
                            <?php if ($edit_category): ?>
                                <a href="categories.php" class="btn">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <!-- Categories List -->
                <div style="margin-top: 3rem;">
                    <div class="toolbar">
                        <h2>All Categories</h2>
                    </div>
                    
                    <div class="data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name (EN)</th>
                                    <th>Name (AR)</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td>
                                        <?php if ($category['image']): ?>
                                            <img src="../<?php echo $category['image']; ?>" alt="">
                                        <?php else: ?>
                                            <div style="width: 80px; height: 60px; background: var(--light-gold); border-radius: 6px;"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($category['name_en']); ?></td>
                                    <td dir="rtl"><?php echo htmlspecialchars($category['name_ar']); ?></td>
                                    <td><?php echo $category['display_order']; ?></td>
                                    <td>
                                        <span class="badge <?php echo $category['is_active'] ? 'badge-active' : 'badge-inactive'; ?>">
                                            <?php echo $category['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="?edit=<?php echo $category['id']; ?>" class="btn btn-edit">Edit</a>
                                        <a href="?delete=<?php echo $category['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>