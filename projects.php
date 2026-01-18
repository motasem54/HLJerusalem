<?php
require_once 'config/config.php';
require_once 'includes/header.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 9;
$offset = ($page - 1) * $per_page;

// Get total count
$total = $db->query("SELECT COUNT(*) as total FROM projects WHERE is_active = 1")->fetch()['total'];
$total_pages = ceil($total / $per_page);

// Get projects
$stmt = $db->prepare("
    SELECT * FROM projects 
    WHERE is_active = 1 
    ORDER BY display_order ASC, created_at DESC 
    LIMIT ? OFFSET ?
");
$stmt->execute([$per_page, $offset]);
$projects = $stmt->fetchAll();
?>

<!-- Page Header -->
<section class="page-header" style="margin-top: 80px; background: linear-gradient(135deg, #1A1A1A 0%, #3E2F1F 100%); padding: 60px 0; color: #fff; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; color: #D4AF37; margin-bottom: 15px;">Our Projects</h1>
        <p style="font-size: 18px; color: #F5F5DC;">Showcasing Excellence in Stone & Marble Worldwide</p>
    </div>
</section>

<!-- Projects Grid -->
<section style="padding: 80px 0;">
    <div class="container">
        <?php if (count($projects) > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 35px;">
            <?php foreach ($projects as $project): ?>
            <div style="background: #fff; box-shadow: 0 5px 20px rgba(0,0,0,0.1); overflow: hidden; transition: all 0.3s;">
                <div style="height: 280px; overflow: hidden;">
                    <?php if ($project['main_image']): ?>
                        <img src="<?= UPLOAD_URL ?>/projects/<?= $project['main_image'] ?>" 
                             alt="<?= $project['title_en'] ?>"
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                    <?php else: ?>
                        <img src="assets/images/project-placeholder.jpg" 
                             alt="<?= $project['title_en'] ?>"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    <?php endif; ?>
                </div>
                <div style="padding: 30px;">
                    <h3 style="font-size: 22px; color: #5D4E37; margin-bottom: 12px;"><?= $project['title_en'] ?></h3>
                    <p style="color: #D4AF37; font-size: 14px; margin-bottom: 12px; font-weight: 600;">
                        📍 <?= $project['location'] ?><?= $project['country'] ? ', ' . $project['country'] : '' ?>
                    </p>
                    <?php if ($project['description_en']): ?>
                    <p style="color: #666; line-height: 1.6; margin-bottom: 15px;">
                        <?= substr($project['description_en'], 0, 150) ?>...
                    </p>
                    <?php endif; ?>
                    <?php if ($project['project_date']): ?>
                    <p style="color: #999; font-size: 13px;">
                        📅 <?= date('F Y', strtotime($project['project_date'])) ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div style="margin-top: 60px; text-align: center;">
            <div style="display: inline-flex; gap: 10px;">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" 
                   style="padding: 10px 20px; background: <?= $i == $page ? '#D4AF37' : '#fff' ?>; color: <?= $i == $page ? '#1A1A1A' : '#666' ?>; border: 2px solid #D4AF37; text-decoration: none; font-weight: 600;">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div style="text-align: center; padding: 60px 20px;">
            <h3 style="font-size: 24px; color: #666;">No projects available yet</h3>
            <p style="color: #999; margin-top: 10px;">Please check back soon for our latest completed projects</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>