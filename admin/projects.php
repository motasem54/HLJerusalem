<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);
    header('Location: projects.php?msg=deleted');
    exit;
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $title_en = $_POST['title_en'];
    $title_ar = $_POST['title_ar'];
    $description_en = $_POST['description_en'];
    $description_ar = $_POST['description_ar'];
    $location = $_POST['location'];
    $project_year = $_POST['project_year'];
    $display_order = (int)$_POST['display_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle image upload
    $main_image = null;
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === 0) {
        $upload_dir = '../uploads/projects/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $main_image = 'uploads/projects/' . time() . '_' . $_FILES['main_image']['name'];
        move_uploaded_file($_FILES['main_image']['tmp_name'], '../' . $main_image);
    }
    
    if ($id) {
        // Update
        $sql = "UPDATE projects SET title_en = ?, title_ar = ?, description_en = ?, description_ar = ?, 
                location = ?, project_year = ?, display_order = ?, is_active = ?";
        $params = [$title_en, $title_ar, $description_en, $description_ar, $location, $project_year, $display_order, $is_active];
        
        if ($main_image) {
            $sql .= ", main_image = ?";
            $params[] = $main_image;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $id;
        
        $pdo->prepare($sql)->execute($params);
        header('Location: projects.php?msg=updated');
    } else {
        // Insert
        $pdo->prepare(
            "INSERT INTO projects (title_en, title_ar, description_en, description_ar, main_image, location, project_year, display_order, is_active) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        )->execute([$title_en, $title_ar, $description_en, $description_ar, $main_image, $location, $project_year, $display_order, $is_active]);
        header('Location: projects.php?msg=added');
    }
    exit;
}

// Get all projects
$projects = $pdo->query("SELECT * FROM projects ORDER BY display_order ASC, title_en ASC")->fetchAll();

// Get single project for editing
$edit_project = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_project = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $edit_project->execute([$edit_id]);
    $edit_project = $edit_project->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Projects Management</h1>
            </header>
            
            <div class="admin-content">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success">
                        <?php
                        echo match($_GET['msg']) {
                            'added' => 'Project added successfully!',
                            'updated' => 'Project updated successfully!',
                            'deleted' => 'Project deleted successfully!',
                            default => ''
                        };
                        ?>
                    </div>
                <?php endif; ?>
                
                <!-- Add/Edit Form -->
                <div class="form-container">
                    <h2><?php echo $edit_project ? 'Edit Project' : 'Add New Project'; ?></h2>
                    <form method="POST" enctype="multipart/form-data">
                        <?php if ($edit_project): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_project['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label>Title (English) *</label>
                            <input type="text" name="title_en" value="<?php echo htmlspecialchars($edit_project['title_en'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Title (Arabic)</label>
                            <input type="text" name="title_ar" value="<?php echo htmlspecialchars($edit_project['title_ar'] ?? ''); ?>" dir="rtl">
                        </div>
                        
                        <div class="form-group">
                            <label>Description (English)</label>
                            <textarea name="description_en"><?php echo htmlspecialchars($edit_project['description_en'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Description (Arabic)</label>
                            <textarea name="description_ar" dir="rtl"><?php echo htmlspecialchars($edit_project['description_ar'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Main Image</label>
                            <input type="file" name="main_image" accept="image/*">
                            <?php if ($edit_project && $edit_project['main_image']): ?>
                                <img src="../<?php echo $edit_project['main_image']; ?>" style="width: 200px; margin-top: 10px; border-radius: 8px;">
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" value="<?php echo htmlspecialchars($edit_project['location'] ?? ''); ?>" placeholder="e.g., Dubai, UAE">
                        </div>
                        
                        <div class="form-group">
                            <label>Project Year</label>
                            <input type="number" name="project_year" value="<?php echo $edit_project['project_year'] ?? date('Y'); ?>" min="1979" max="<?php echo date('Y') + 5; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" name="display_order" value="<?php echo $edit_project['display_order'] ?? 0; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_active" <?php echo (!$edit_project || $edit_project['is_active']) ? 'checked' : ''; ?>>
                                Active
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?php echo $edit_project ? 'Update' : 'Add'; ?> Project</button>
                            <?php if ($edit_project): ?>
                                <a href="projects.php" class="btn">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <!-- Projects List -->
                <div style="margin-top: 3rem;">
                    <div class="toolbar">
                        <h2>All Projects (<?php echo count($projects); ?>)</h2>
                    </div>
                    
                    <div class="data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>Year</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td>
                                        <?php if ($project['main_image']): ?>
                                            <img src="../<?php echo $project['main_image']; ?>" alt="">
                                        <?php else: ?>
                                            <div style="width: 80px; height: 60px; background: var(--light-gold); border-radius: 6px;"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($project['title_en']); ?></td>
                                    <td><?php echo htmlspecialchars($project['location'] ?? '-'); ?></td>
                                    <td><?php echo $project['project_year'] ?? '-'; ?></td>
                                    <td><?php echo $project['display_order']; ?></td>
                                    <td>
                                        <span class="badge <?php echo $project['is_active'] ? 'badge-active' : 'badge-inactive'; ?>">
                                            <?php echo $project['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="?edit=<?php echo $project['id']; ?>" class="btn btn-edit">Edit</a>
                                        <a href="?delete=<?php echo $project['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
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