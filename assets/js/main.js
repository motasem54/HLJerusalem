// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Header scroll effect
window.addEventListener('scroll', () => {
    const header = document.querySelector('header');
    if (window.scrollY > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Active navigation link
const sections = document.querySelectorAll('.section, .hero');
const navLinks = document.querySelectorAll('.nav-menu a');

window.addEventListener('scroll', () => {
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === current) {
            link.classList.add('active');
        }
    });
});

// Load Products
async function loadProducts() {
    try {
        const response = await fetch('api/get-products.php');
        const data = await response.json();
        
        const container = document.getElementById('productsContainer');
        if (data.success && data.products.length > 0) {
            container.innerHTML = data.products.map(product => `
                <div class="product-card">
                    <img src="${product.main_image || 'assets/images/placeholder.jpg'}" alt="${product.name_en}" class="product-image">
                    <div class="product-info">
                        <h3 class="product-name">${product.name_en}</h3>
                        <p class="product-description">${product.description_en || ''}</p>
                        <div class="product-meta">
                            ${product.color_range ? `<span class="meta-tag">Color: ${product.color_range}</span>` : ''}
                            ${product.available_types ? `<span class="meta-tag">${product.available_types}</span>` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<p style="text-align: center; color: var(--secondary-brown); grid-column: 1/-1;">No products available at the moment.</p>';
        }
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

// Load Projects
async function loadProjects() {
    try {
        const response = await fetch('api/get-projects.php');
        const data = await response.json();
        
        const container = document.getElementById('projectsContainer');
        if (data.success && data.projects.length > 0) {
            container.innerHTML = data.projects.map(project => `
                <div class="product-card">
                    <img src="${project.main_image || 'assets/images/placeholder.jpg'}" alt="${project.title_en}" class="product-image">
                    <div class="product-info">
                        <h3 class="product-name">${project.title_en}</h3>
                        <p class="product-description">${project.description_en || ''}</p>
                        ${project.location ? `<p style="color: var(--primary-gold); font-weight: 600; margin-top: 1rem;">${project.location}</p>` : ''}
                        ${project.project_year ? `<p style="color: var(--secondary-brown);">Year: ${project.project_year}</p>` : ''}
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<p style="text-align: center; color: var(--secondary-brown); grid-column: 1/-1;">No projects available at the moment.</p>';
        }
    } catch (error) {
        console.error('Error loading projects:', error);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    loadProducts();
    loadProjects();
});