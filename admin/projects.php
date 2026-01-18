<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once '../includes/config.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: projects.php?msg=deleted');
    exit();
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_en = $_POST['title_en'];
    $title_ar = $_POST['title_ar'] ?? '';
    $description_en = $_POST['description_en'];
    $description_ar = $_POST['description_ar'] ?? '';
    $location = $_POST['location'];
    $completed_date = $_POST['completed_date'];
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../assets/images/projects/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('project_') . '.' . $file_extension;
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
            $image = 'assets/images/projects/' . $file_name;
        }
    }
    
    if (isset($_POST['id']) && $_POST['id']) {
        // Update
        $id = (int)$_POST['id'];
        if ($image) {
            $stmt = $conn->prepare("UPDATE projects SET title_en=?, title_ar=?, description_en=?, description_ar=?, location=?, image=?, completed_date=? WHERE id=?");
            $stmt->execute([$title_en, $title_ar, $description_en, $description_ar, $location, $image, $completed_date, $id]);
        } else {
            $stmt = $conn->prepare("UPDATE projects SET title_en=?, title_ar=?, description_en=?, description_ar=?, location=?, completed_date=? WHERE id=?");
            $stmt->execute([$title_en, $title_ar, $description_en, $description_ar, $location, $completed_date, $id]);
        }
        header('Location: projects.php?msg=updated');
    } else {
        // Insert
        $stmt = $conn->prepare("INSERT INTO projects (title_en, title_ar, description_en, description_ar, location, image, completed_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title_en, $title_ar, $description_en, $description_ar, $location, $image, $completed_date]);
        header('Location: projects.php?msg=added');
    }
    exit();
}

// Fetch all projects
$stmt = $conn->query("SELECT * FROM projects ORDER BY completed_date DESC, created_at DESC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch single project for editing
$edit_project = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $edit_project = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects - H.L. Jerusalem Admin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <nav class="admin-sidebar">
            <div class="admin-logo">
                <h2>H.L. Jerusalem</h2>
                <p>Admin Panel</p>
            </div>
            <ul class="admin-menu">
                <li><a href="index.php">🏠 Dashboard</a></li>
                <li><a href="categories.php">📋 Categories</a></li>
                <li><a href="products.php">📦 Products</a></li>
                <li><a href="projects.php" class="active">🏛️ Projects</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
        </nav>

        <main class="admin-content">
            <div class="admin-header">
                <h1>🏛️ Manage Projects</h1>
                <p>Showcase your company's finest work</p>
            </div>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success">
                    <?php 
                    if ($_GET['msg'] === 'added') echo 'Project added successfully!';
                    elseif ($_GET['msg'] === 'updated') echo 'Project updated successfully!';
                    elseif ($_GET['msg'] === 'deleted') echo 'Project deleted successfully!';
                    ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3><?php echo $edit_project ? 'Edit Project' : 'Add New Project'; ?></h3>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" class="form">
                        <?php if ($edit_project): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_project['id']; ?>">
                        <?php endif; ?>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Project Title (English) *</label>
                                <input type="text" name="title_en" required 
                                       value="<?php echo $edit_project['title_en'] ?? ''; ?>">
                            </div>

                            <div class="form-group">
                                <label>Project Title (Arabic)</label>
                                <input type="text" name="title_ar" 
                                       value="<?php echo $edit_project['title_ar'] ?? ''; ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Location *</label>
                                <input type="text" name="location" required 
                                       value="<?php echo $edit_project['location'] ?? ''; ?>" 
                                       placeholder="e.g., Riyadh, Saudi Arabia">
                            </div>

                            <div class="form-group">
                                <label>Completion Date</label>
                                <input type="date" name="completed_date" 
                                       value="<?php echo $edit_project['completed_date'] ?? ''; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description (English) *</label>
                            <textarea name="description_en" rows="4" required><?php echo $edit_project['description_en'] ?? ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Description (Arabic)</label>
                            <textarea name="description_ar" rows="4"><?php echo $edit_project['description_ar'] ?? ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Project Image *</label>
                            <input type="file" name="image" accept="image/*" <?php echo !$edit_project ? 'required' : ''; ?>>
                            <?php if ($edit_project && $edit_project['image']): ?>
                                <small>Current image: <?php echo basename($edit_project['image']); ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $edit_project ? 'Update Project' : 'Add Project'; ?>
                            </button>
                            <?php if ($edit_project): ?>
                                <a href="projects.php" class="btn btn-secondary">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card" style="margin-top: 30px;">
                <div class="card-header">
                    <h3>All Projects (<?php echo count($projects); ?>)</h3>
                </div>
                <div class="card-body">
                    <?php if (count($projects) > 0): ?>
                        <div class="projects-grid">
                            <?php foreach ($projects as $project): ?>
                                <div class="project-item">
                                    <?php if ($project['image']): ?>
                                        <img src="../<?php echo htmlspecialchars($project['image']); ?>" alt="Project">
                                    <?php endif; ?>
                                    <div class="project-info">
                                        <h4><?php echo htmlspecialchars($project['title_en']); ?></h4>
                                        <p class="location">📍 <?php echo htmlspecialchars($project['location']); ?></p>
                                        <?php if ($project['completed_date']): ?>
                                            <p class="date">📅 <?php echo date('M Y', strtotime($project['completed_date'])); ?></p>
                                        <?php endif; ?>
                                        <div class="actions">
                                            <a href="?edit=<?php echo $project['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="?delete=<?php echo $project['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Delete this project?')">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="no-data">No projects yet. Add your first project above.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <style>
    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .project-item {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }
    
    .project-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .project-info {
        padding: 15px;
    }
    
    .project-info h4 {
        margin: 0 0 10px 0;
        color: #3E2723;
    }
    
    .project-info .location,
    .project-info .date {
        font-size: 0.9rem;
        color: #666;
        margin: 5px 0;
    }
    
    .actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }
    </style>
</body>
</html>