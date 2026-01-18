<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
    header('Location: products.php?msg=deleted');
    exit;
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $category_id = (int)$_POST['category_id'];
    $name_en = $_POST['name_en'];
    $name_ar = $_POST['name_ar'];
    $description_en = $_POST['description_en'];
    $description_ar = $_POST['description_ar'];
    $color_range = $_POST['color_range'];
    $dimensions = $_POST['dimensions'];
    $available_types = $_POST['available_types'];
    $display_order = (int)$_POST['display_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    // Handle image upload
    $main_image = null;
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === 0) {
        $upload_dir = '../uploads/products/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $main_image = 'uploads/products/' . time() . '_' . $_FILES['main_image']['name'];
        move_uploaded_file($_FILES['main_image']['tmp_name'], '../' . $main_image);
    }
    
    if ($id) {
        // Update
        $sql = "UPDATE products SET category_id = ?, name_en = ?, name_ar = ?, description_en = ?, description_ar = ?, 
                color_range = ?, dimensions = ?, available_types = ?, display_order = ?, is_active = ?, is_featured = ?";
        $params = [$category_id, $name_en, $name_ar, $description_en, $description_ar, $color_range, 
                   $dimensions, $available_types, $display_order, $is_active, $is_featured];
        
        if ($main_image) {
            $sql .= ", main_image = ?";
            $params[] = $main_image;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $id;
        
        $pdo->prepare($sql)->execute($params);
        header('Location: products.php?msg=updated');
    } else {
        // Insert
        $pdo->prepare(
            "INSERT INTO products (category_id, name_en, name_ar, description_en, description_ar, main_image, 
                                   color_range, dimensions, available_types, display_order, is_active, is_featured) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        )->execute([$category_id, $name_en, $name_ar, $description_en, $description_ar, $main_image, 
                    $color_range, $dimensions, $available_types, $display_order, $is_active, $is_featured]);
        header('Location: products.php?msg=added');
    }
    exit;
}

// Get all products with category names
$products = $pdo->query("
    SELECT p.*, c.name_en as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    ORDER BY p.display_order ASC, p.name_en ASC
")->fetchAll();

// Get all categories for dropdown
$categories = $pdo->query("SELECT id, name_en FROM categories WHERE is_active = 1 ORDER BY name_en")->fetchAll();

// Get single product for editing
$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $edit_product->execute([$edit_id]);
    $edit_product = $edit_product->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Products Management</h1>
            </header>
            
            <div class="admin-content">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success">
                        <?php
                        echo match($_GET['msg']) {
                            'added' => 'Product added successfully!',
                            'updated' => 'Product updated successfully!',
                            'deleted' => 'Product deleted successfully!',
                            default => ''
                        };
                        ?>
                    </div>
                <?php endif; ?>
                
                <!-- Add/Edit Form -->
                <div class="form-container">
                    <h2><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h2>
                    <form method="POST" enctype="multipart/form-data">
                        <?php if ($edit_product): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" 
                                        <?php echo ($edit_product && $edit_product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name_en']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Name (English) *</label>
                            <input type="text" name="name_en" value="<?php echo htmlspecialchars($edit_product['name_en'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Name (Arabic)</label>
                            <input type="text" name="name_ar" value="<?php echo htmlspecialchars($edit_product['name_ar'] ?? ''); ?>" dir="rtl">
                        </div>
                        
                        <div class="form-group">
                            <label>Description (English)</label>
                            <textarea name="description_en"><?php echo htmlspecialchars($edit_product['description_en'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Description (Arabic)</label>
                            <textarea name="description_ar" dir="rtl"><?php echo htmlspecialchars($edit_product['description_ar'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Main Image</label>
                            <input type="file" name="main_image" accept="image/*">
                            <?php if ($edit_product && $edit_product['main_image']): ?>
                                <img src="../<?php echo $edit_product['main_image']; ?>" style="width: 200px; margin-top: 10px; border-radius: 8px;">
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Color Range</label>
                            <input type="text" name="color_range" value="<?php echo htmlspecialchars($edit_product['color_range'] ?? ''); ?>" placeholder="e.g., White to Cream">
                        </div>
                        
                        <div class="form-group">
                            <label>Dimensions</label>
                            <input type="text" name="dimensions" value="<?php echo htmlspecialchars($edit_product['dimensions'] ?? ''); ?>" placeholder="e.g., 60x30cm">
                        </div>
                        
                        <div class="form-group">
                            <label>Available Types</label>
                            <input type="text" name="available_types" value="<?php echo htmlspecialchars($edit_product['available_types'] ?? ''); ?>" placeholder="e.g., Blocks, Slabs, Tiles">
                        </div>
                        
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" name="display_order" value="<?php echo $edit_product['display_order'] ?? 0; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_featured" <?php echo ($edit_product && $edit_product['is_featured']) ? 'checked' : ''; ?>>
                                Featured Product
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_active" <?php echo (!$edit_product || $edit_product['is_active']) ? 'checked' : ''; ?>>
                                Active
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?php echo $edit_product ? 'Update' : 'Add'; ?> Product</button>
                            <?php if ($edit_product): ?>
                                <a href="products.php" class="btn">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <!-- Products List -->
                <div style="margin-top: 3rem;">
                    <div class="toolbar">
                        <h2>All Products (<?php echo count($products); ?>)</h2>
                    </div>
                    
                    <div class="data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Color Range</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <?php if ($product['main_image']): ?>
                                            <img src="../<?php echo $product['main_image']; ?>" alt="">
                                        <?php else: ?>
                                            <div style="width: 80px; height: 60px; background: var(--light-gold); border-radius: 6px;"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['name_en']); ?></td>
                                    <td><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($product['color_range'] ?? '-'); ?></td>
                                    <td>
                                        <?php if ($product['is_featured']): ?>
                                            <span style="color: var(--primary-gold); font-weight: 600;">★ Featured</span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $product['is_active'] ? 'badge-active' : 'badge-inactive'; ?>">
                                            <?php echo $product['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="?edit=<?php echo $product['id']; ?>" class="btn btn-edit">Edit</a>
                                        <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
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