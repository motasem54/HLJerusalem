<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Premium Natural Stone from Palestine</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo-container">
                <img src="assets/images/logo.png" alt="H.L. Jerusalem Logo" class="logo">
                <span class="company-name">H.L. JERUSALEM</span>
            </div>
            <ul class="nav-menu">
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>EXCEPTIONAL NATURAL STONE</h1>
            <p>Since 1979, we've been crafting excellence in Jerusalem Gold Stone and premium marble products for discerning clients worldwide</p>
            <a href="#products" class="cta-button">Explore Our Collection</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="section" id="about">
        <h2 class="section-title">About H.L. Jerusalem</h2>
        <p class="section-subtitle">Leading the natural stone industry since 1979</p>
        
        <div class="about-content">
            <div class="about-text">
                <h3>Heritage of Excellence</h3>
                <p>Incorporated in 1979, H.L. Jerusalem Stone and Marble is ranked among the biggest companies in producing and manufacturing the beautiful Jerusalem gold stone in Palestine. Founded in Hebron, one of the oldest cities in the West Bank, we started as a small family business.</p>
                
                <p>Our products including Blocks, Slabs, Tiles, and Cut to size can be tailored to your needs with polished, honed, sandblasted, bush-hammered, light, rough, chiseled and flamed finishes, as well as various types of antique and tumbled finishes.</p>
                
                <p>Our natural stone colors range from white to cream and from red to grey and yellow, offering endless possibilities for architectural excellence.</p>
            </div>
            <div>
                <img src="assets/images/about-image.jpg" alt="H.L. Jerusalem Stone" class="about-image">
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number">1979</div>
                <div class="stat-label">Established</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">990K</div>
                <div class="stat-label">m² Quarry Area</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">25K</div>
                <div class="stat-label">m³ Annual Production</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">20K</div>
                <div class="stat-label">m² Monthly Output</div>
            </div>
        </div>
    </section>

    <!-- Global Presence Section -->
    <section class="section" style="background: var(--white);">
        <h2 class="section-title">Global Presence</h2>
        <p class="section-subtitle">Expanding our excellence across continents</p>
        
        <div class="about-content">
            <div class="about-text">
                <h3>International Investments</h3>
                <p>Since we believe in quality and mutual benefit by providing the most competitive price in the world market for top quality products, we have entered different important markets:</p>
                
                <p><strong style="color: var(--primary-gold);">Korea:</strong> Through our investment company H.L Jerusalem Sara</p>
                <p><strong style="color: var(--primary-gold);">Turkey:</strong> Through our investment company H.L. Jerusalem Madencilik, operating one of our biggest quarries (990,000 m²) with beautiful cream color range</p>
                <p><strong style="color: var(--primary-gold);">Jordan:</strong> Through our investment company H.L. Jerusalem Tala Bay</p>
                
                <p>We survive by creating successful partnerships with our clients all over the world, supported by advanced technologies and five Italian production lines managed by our professional employees.</p>
            </div>
            <div>
                <img src="assets/images/global-map.jpg" alt="Global Presence" class="about-image">
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="section" id="products">
        <h2 class="section-title">Our Products</h2>
        <p class="section-subtitle">Premium natural stone solutions for every project</p>
        
        <div class="products-grid" id="productsContainer">
            <!-- Products will be loaded dynamically -->
        </div>
    </section>

    <!-- Projects Section -->
    <section class="section" id="projects" style="background: var(--white);">
        <h2 class="section-title">Featured Projects</h2>
        <p class="section-subtitle">Excellence in every installation</p>
        
        <div class="products-grid" id="projectsContainer">
            <!-- Projects will be loaded dynamically -->
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section" id="contact">
        <h2 class="section-title">Contact Us</h2>
        <p class="section-subtitle">Get in touch with our team</p>
        
        <div class="about-content" style="margin-top: 3rem;">
            <div class="about-text">
                <h3 style="color: var(--primary-gold); margin-bottom: 2rem;">H.L. JERUSALEM STONE & MARBLE</h3>
                
                <div style="margin-bottom: 2rem;">
                    <h4 style="color: var(--primary-brown); margin-bottom: 0.5rem;">ADDRESS</h4>
                    <p>Ein Sarah St. Hebron, Palestine</p>
                </div>
                
                <div style="margin-bottom: 2rem;">
                    <h4 style="color: var(--primary-brown); margin-bottom: 0.5rem;">EMAIL</h4>
                    <p><a href="mailto:info@palstone.com" style="color: var(--primary-gold);">info@palstone.com</a></p>
                </div>
                
                <div style="margin-bottom: 2rem;">
                    <h4 style="color: var(--primary-brown); margin-bottom: 0.5rem;">PHONE & FAX</h4>
                    <p>Tel: +970 2 2291403</p>
                    <p>Fax: +970 2 2253133</p>
                </div>
            </div>
            
            <div>
                <h3 style="color: var(--primary-brown); margin-bottom: 2rem;">Management Team</h3>
                
                <div style="background: var(--light-gold); padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <h4 style="color: var(--primary-brown);">GENERAL MANAGER</h4>
                    <p style="color: var(--secondary-brown); font-weight: 600;">MR. FAHED GHAITH</p>
                    <p style="color: var(--secondary-brown);">+970-599373163</p>
                </div>
                
                <div style="background: var(--light-gold); padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <h4 style="color: var(--primary-brown);">DIRECTOR MANAGER</h4>
                    <p style="color: var(--secondary-brown); font-weight: 600;">MR. NIMER GHAITH</p>
                    <p style="color: var(--secondary-brown);">+972-598881778</p>
                </div>
                
                <div style="background: var(--light-gold); padding: 1.5rem; border-radius: 8px;">
                    <h4 style="color: var(--primary-brown);">MARKETING MANAGER</h4>
                    <p style="color: var(--secondary-brown); font-weight: 600;">MISS. OLA GHAITH</p>
                    <p style="color: var(--secondary-brown);">+970-595188753</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>H.L. JERUSALEM</h3>
                <p>Premium natural stone products from Palestine since 1979. We are not just a company for manufacturing and exporting stones and marble, we are looking forward to support the Palestinian economy.</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="#home">Home</a></p>
                <p><a href="#about">About</a></p>
                <p><a href="#products">Products</a></p>
                <p><a href="#projects">Projects</a></p>
                <p><a href="#contact">Contact</a></p>
            </div>
            
            <div class="footer-section">
                <h3>Contact Info</h3>
                <p>Ein Sarah St. Hebron, Palestine</p>
                <p>Email: info@palstone.com</p>
                <p>Tel: +970 2 2291403</p>
                <p>Fax: +970 2 2253133</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> H.L. Jerusalem Stone & Marble. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>