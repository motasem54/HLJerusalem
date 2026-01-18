<?php
require_once 'config/config.php';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <img src="assets/images/logo.png" alt="H.L. Jerusalem Logo" class="hero-logo">
        <h1 class="hero-title">H.L. JERUSALEM</h1>
        <p class="hero-subtitle">Stone & Marble Company</p>
        <p class="hero-tagline">Premium Natural Stone Since 1979</p>
        <a href="#products" class="btn-gold">Explore Products</a>
    </div>
    <div class="scroll-indicator">
        <span></span>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">About H.L. Jerusalem</h2>
            <div class="title-divider"></div>
        </div>
        <div class="about-content">
            <div class="about-text">
                <p class="lead-text">
                    Incorporated in 1979, H.L. Jerusalem Stone and Marble is ranked among the biggest companies 
                    in producing and manufacturing the beautiful Jerusalem gold stone in Palestine.
                </p>
                <p>
                    Founded in Hebron, one of the oldest cities in the West Bank, Palestine, as a small family business, 
                    we have grown to become a leading force in the natural stone industry.
                </p>
                <p>
                    We believe in quality and mutual benefit by providing the most competitive prices in the world market 
                    for top-quality products. We're not just a company for manufacturing and exporting stones and marble; 
                    we're committed to supporting the Palestinian economy.
                </p>
            </div>
            <div class="about-stats">
                <div class="stat-item">
                    <span class="stat-number">1979</span>
                    <span class="stat-label">Established</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">20,000</span>
                    <span class="stat-label">m² Monthly Production</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">3</span>
                    <span class="stat-label">International Branches</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5</span>
                    <span class="stat-label">Italian Production Lines</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section" id="products">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Products</h2>
            <div class="title-divider"></div>
            <p class="section-description">
                Our products can be tailored to your needs in various finishes including polished, honed, 
                sandblasted, bush-hammered, and antique/tumbled finish.
            </p>
        </div>
        
        <div class="products-grid">
            <?php
            $stmt = $db->prepare("SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order ASC LIMIT 4");
            $stmt->execute();
            $categories = $stmt->fetchAll();
            
            foreach ($categories as $category):
            ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if ($category['image']): ?>
                        <img src="<?= UPLOAD_URL ?>/categories/<?= $category['image'] ?>" alt="<?= $category['name_en'] ?>">
                    <?php else: ?>
                        <img src="assets/images/placeholder.jpg" alt="<?= $category['name_en'] ?>">
                    <?php endif; ?>
                    <div class="product-overlay">
                        <a href="category.php?slug=<?= $category['slug'] ?>" class="btn-view">View Products</a>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-title"><?= $category['name_en'] ?></h3>
                    <p class="product-description"><?= substr($category['description_en'], 0, 100) ?>...</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center">
            <a href="products.php" class="btn-outline-gold">View All Products</a>
        </div>
    </div>
</section>

<!-- Product Types -->
<section class="types-section">
    <div class="container">
        <div class="types-grid">
            <div class="type-item">
                <div class="type-icon">🗻</div>
                <h3>Blocks</h3>
                <p>Raw stone blocks from our quarries</p>
            </div>
            <div class="type-item">
                <div class="type-icon">📐</div>
                <h3>Slabs</h3>
                <p>Cut and polished stone slabs</p>
            </div>
            <div class="type-item">
                <div class="type-icon">⬜</div>
                <h3>Tiles</h3>
                <p>Various tile sizes and formats</p>
            </div>
            <div class="type-item">
                <div class="type-icon">✂️</div>
                <h3>Cut to Size</h3>
                <p>Custom dimensions on request</p>
            </div>
        </div>
    </div>
</section>

<!-- International Presence -->
<section class="international-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">International Presence</h2>
            <div class="title-divider"></div>
            <p class="section-description">
                We have entered different important markets through strategic investments
            </p>
        </div>
        
        <div class="branches-grid">
            <div class="branch-card">
                <div class="branch-flag">🇰🇷</div>
                <h3>Korea</h3>
                <p class="branch-name">H.L Jerusalem Sara</p>
            </div>
            <div class="branch-card">
                <div class="branch-flag">🇹🇷</div>
                <h3>Turkey</h3>
                <p class="branch-name">H.L. Jerusalem Madencilik</p>
                <p class="branch-details">990,000 m² quarry | 25,000 m³ annual production</p>
            </div>
            <div class="branch-card">
                <div class="branch-flag">🇯🇴</div>
                <h3>Jordan</h3>
                <p class="branch-name">H.L. Jerusalem Tala Bay</p>
            </div>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="projects-section" id="projects">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Projects</h2>
            <div class="title-divider"></div>
        </div>
        
        <div class="projects-grid">
            <?php
            $stmt = $db->prepare("SELECT * FROM projects WHERE is_active = 1 ORDER BY display_order ASC LIMIT 6");
            $stmt->execute();
            $projects = $stmt->fetchAll();
            
            if (count($projects) > 0):
                foreach ($projects as $project):
            ?>
            <div class="project-card">
                <div class="project-image">
                    <?php if ($project['main_image']): ?>
                        <img src="<?= UPLOAD_URL ?>/projects/<?= $project['main_image'] ?>" alt="<?= $project['title_en'] ?>">
                    <?php else: ?>
                        <img src="assets/images/project-placeholder.jpg" alt="<?= $project['title_en'] ?>">
                    <?php endif; ?>
                </div>
                <div class="project-info">
                    <h3><?= $project['title_en'] ?></h3>
                    <p class="project-location">📍 <?= $project['location'] ?>, <?= $project['country'] ?></p>
                </div>
            </div>
            <?php 
                endforeach;
            else:
            ?>
            <div class="no-projects">
                <p>Projects will be showcased here soon.</p>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if (count($projects) > 0): ?>
        <div class="text-center">
            <a href="projects.php" class="btn-outline-gold">View All Projects</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Contact Us</h2>
            <div class="title-divider"></div>
        </div>
        
        <div class="contact-content">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">📍</div>
                    <div>
                        <h4>Address</h4>
                        <p>Ein Sarah St. Hebron, Palestine</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">📧</div>
                    <div>
                        <h4>Email</h4>
                        <p><a href="mailto:info@palstone.com">info@palstone.com</a></p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <div>
                        <h4>Phone</h4>
                        <p>+970 2 2291403</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">📠</div>
                    <div>
                        <h4>Fax</h4>
                        <p>+970 2 2253133</p>
                    </div>
                </div>
                
                <div class="management-info">
                    <h4>Management</h4>
                    <p><strong>General Manager:</strong><br>Mr. Fahed Ghaith: 00970-599373163</p>
                    <p><strong>Director Manager:</strong><br>Mr. Nimer Ghaith: 00972-598881778</p>
                    <p><strong>Marketing Manager:</strong><br>Miss. Ola Ghaith: 00970-595188753</p>
                </div>
            </div>
            
            <div class="contact-form">
                <form method="POST" action="process-contact.php" id="contactForm">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn-gold">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>