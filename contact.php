<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<style>
.contact-hero {
    background: linear-gradient(135deg, #3E2723 0%, #1A1A1A 100%);
    padding: 120px 20px 80px;
    text-align: center;
    color: #fff;
}

.contact-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    color: #C9A961;
    margin-bottom: 20px;
}

.contact-hero p {
    font-size: 1.2rem;
    color: #F5F5DC;
    max-width: 700px;
    margin: 0 auto;
}

.contact-container {
    max-width: 1400px;
    margin: 80px auto;
    padding: 0 20px;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    margin-top: 60px;
}

.contact-card {
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(201, 169, 97, 0.2);
}

.contact-icon {
    font-size: 3rem;
    color: #C9A961;
    margin-bottom: 20px;
}

.contact-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    color: #3E2723;
    margin-bottom: 20px;
}

.contact-info {
    color: #666;
    line-height: 2;
}

.contact-info a {
    color: #C9A961;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-info a:hover {
    color: #D4AF37;
}

.management-section {
    margin-top: 80px;
    background: linear-gradient(135deg, #F5F5DC 0%, #fff 100%);
    padding: 60px 40px;
    border-radius: 12px;
}

.management-section h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    color: #3E2723;
    text-align: center;
    margin-bottom: 50px;
}

.management-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.manager-card {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    border-left: 4px solid #C9A961;
}

.manager-title {
    font-weight: 700;
    color: #C9A961;
    font-size: 0.9rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.manager-name {
    font-size: 1.4rem;
    color: #3E2723;
    font-weight: 600;
    margin-bottom: 10px;
}

.manager-contact {
    color: #666;
    font-size: 1.1rem;
}

.branches-section {
    margin-top: 80px;
}

.branches-section h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    color: #3E2723;
    text-align: center;
    margin-bottom: 50px;
}

.branches-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.branch-card {
    background: linear-gradient(135deg, #3E2723 0%, #1A1A1A 100%);
    color: #fff;
    padding: 35px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
}

.branch-card:hover {
    transform: translateY(-5px);
}

.branch-flag {
    font-size: 3rem;
    margin-bottom: 15px;
}

.branch-country {
    font-size: 1.5rem;
    color: #C9A961;
    font-weight: 600;
    margin-bottom: 10px;
}

.branch-name {
    color: #F5F5DC;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .contact-hero h1 {
        font-size: 2.5rem;
    }
    
    .contact-grid,
    .management-grid,
    .branches-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="contact-hero">
    <h1>Contact Us</h1>
    <p>Get in touch with H.L. Jerusalem Stone and Marble for your next project</p>
</section>

<div class="contact-container">
    <div class="contact-grid">
        <div class="contact-card">
            <div class="contact-icon">📍</div>
            <h3>Main Office</h3>
            <div class="contact-info">
                <p>Ein Sarah Street<br>
                Hebron, West Bank<br>
                Palestine</p>
            </div>
        </div>

        <div class="contact-card">
            <div class="contact-icon">📧</div>
            <h3>Email Us</h3>
            <div class="contact-info">
                <p><a href="mailto:info@palstone.com">info@palstone.com</a></p>
            </div>
        </div>

        <div class="contact-card">
            <div class="contact-icon">📞</div>
            <h3>Call Us</h3>
            <div class="contact-info">
                <p><strong>Phone:</strong> <a href="tel:+97022291403">+970 2 2291403</a><br>
                <strong>Fax:</strong> +970 2 2253133</p>
            </div>
        </div>
    </div>

    <div class="management-section">
        <h2>Management Team</h2>
        <div class="management-grid">
            <div class="manager-card">
                <div class="manager-title">General Manager</div>
                <div class="manager-name">Mr. Fahed Ghaith</div>
                <div class="manager-contact">📱 <a href="tel:+970599373163">00970-599373163</a></div>
            </div>

            <div class="manager-card">
                <div class="manager-title">Director Manager</div>
                <div class="manager-name">Mr. Nimer Ghaith</div>
                <div class="manager-contact">📱 <a href="tel:+972598881778">00972-598881778</a></div>
            </div>

            <div class="manager-card">
                <div class="manager-title">Marketing Manager</div>
                <div class="manager-name">Miss Ola Ghaith</div>
                <div class="manager-contact">📱 <a href="tel:+970595188753">00970-595188753</a></div>
            </div>
        </div>
    </div>

    <div class="branches-section">
        <h2>International Branches</h2>
        <div class="branches-grid">
            <div class="branch-card">
                <div class="branch-flag">🇰🇷</div>
                <div class="branch-country">South Korea</div>
                <div class="branch-name">H.L Jerusalem Sara</div>
            </div>

            <div class="branch-card">
                <div class="branch-flag">🇹🇷</div>
                <div class="branch-country">Turkey</div>
                <div class="branch-name">H.L. Jerusalem Madencilik</div>
                <p style="margin-top: 10px; font-size: 0.9rem; color: #C9A961;">990,000 m² Quarry</p>
            </div>

            <div class="branch-card">
                <div class="branch-flag">🇯🇴</div>
                <div class="branch-country">Jordan</div>
                <div class="branch-name">H.L. Jerusalem Tala Bay</div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>