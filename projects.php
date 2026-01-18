<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

// Fetch all projects
$stmt = $conn->prepare("SELECT * FROM projects ORDER BY completed_date DESC, created_at DESC");
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
.projects-hero {
    background: linear-gradient(135deg, #1A1A1A 0%, #3E2723 100%);
    padding: 120px 20px 80px;
    text-align: center;
    color: #fff;
}

.projects-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    color: #C9A961;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.projects-hero p {
    font-size: 1.3rem;
    color: #F5F5DC;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
}

.projects-container {
    max-width: 1400px;
    margin: 80px auto;
    padding: 0 20px;
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 40px;
    margin-top: 60px;
}

.project-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    position: relative;
}

.project-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(201, 169, 97, 0.2);
}

.project-image {
    width: 100%;
    height: 350px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.project-card:hover .project-image {
    transform: scale(1.05);
}

.project-content {
    padding: 30px;
}

.project-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    color: #3E2723;
    margin-bottom: 15px;
}

.project-location {
    display: flex;
    align-items: center;
    color: #C9A961;
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 1rem;
}

.project-location::before {
    content: '📍';
    margin-right: 8px;
}

.project-description {
    color: #666;
    line-height: 1.8;
    margin-bottom: 20px;
}

.project-date {
    color: #999;
    font-size: 0.9rem;
    font-style: italic;
}

.no-projects {
    text-align: center;
    padding: 100px 20px;
    color: #666;
}

.no-projects-icon {
    font-size: 4rem;
    color: #C9A961;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .projects-hero h1 {
        font-size: 2.5rem;
    }
    
    .projects-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .project-image {
        height: 250px;
    }
}
</style>

<section class="projects-hero">
    <h1>Our Projects</h1>
    <p>Showcasing our finest work across the Middle East and beyond. Each project represents our commitment to excellence and quality craftsmanship.</p>
</section>

<div class="projects-container">
    <?php if (count($projects) > 0): ?>
        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <img src="<?php echo htmlspecialchars($project['image']); ?>" 
                         alt="<?php echo htmlspecialchars($project['title_en']); ?>" 
                         class="project-image">
                    <div class="project-content">
                        <h3 class="project-title"><?php echo htmlspecialchars($project['title_en']); ?></h3>
                        <div class="project-location"><?php echo htmlspecialchars($project['location']); ?></div>
                        <p class="project-description"><?php echo nl2br(htmlspecialchars($project['description_en'])); ?></p>
                        <?php if ($project['completed_date']): ?>
                            <div class="project-date">Completed: <?php echo date('F Y', strtotime($project['completed_date'])); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-projects">
            <div class="no-projects-icon">🏛️</div>
            <h2>No Projects Yet</h2>
            <p>Our showcase projects will be displayed here soon.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>