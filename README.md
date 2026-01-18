# H.L. Jerusalem Stone & Marble Company Website

![H.L. Jerusalem](assets/images/logo.png)

Professional website for **H.L. Jerusalem Stone & Marble Company** - Premium natural stone products from Palestine since 1979.

## 🌟 Features

### Frontend
- **Luxury Design**: Brown, Black, and Gold color scheme for premium brand identity
- **Responsive Layout**: Fully responsive design for all devices
- **Dynamic Content**: Products and projects loaded dynamically from database
- **Smooth Animations**: Professional animations and transitions
- **Multi-language Support**: English (primary) with Arabic support in admin panel

### Admin Panel
- **Complete Control**: Full management of categories, products, and projects
- **User-Friendly Interface**: Intuitive dashboard with quick actions
- **Image Upload**: Easy image management for all content
- **Statistics Dashboard**: Real-time overview of content counts
- **Secure Authentication**: Password-protected admin access

## 🛠️ Technology Stack

- **Backend**: PHP 8.0+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Design**: Custom CSS with CSS Variables
- **Fonts**: Google Fonts (Lato)

## 📋 Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- PHP Extensions: PDO, PDO_MySQL, GD (for image handling)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/motasem54/HLJerusalem.git
cd HLJerusalem
```

### 2. Database Setup
```bash
# Create database and import schema
mysql -u root -p < database.sql
```

Or manually:
1. Create a new database named `hljerusalem`
2. Import the `database.sql` file
3. Default admin credentials will be created automatically

### 3. Configuration
Edit `config.php` with your database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'hljerusalem');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### 4. File Permissions
```bash
chmod 755 uploads/
chmod 755 uploads/categories/
chmod 755 uploads/products/
chmod 755 uploads/projects/
```

### 5. Access the Website
- **Frontend**: `http://localhost/HLJerusalem/`
- **Admin Panel**: `http://localhost/HLJerusalem/admin/`

## 🔐 Default Admin Credentials

- **Username**: `admin`
- **Password**: `admin123`

⚠️ **Important**: Change the default password immediately after first login!

## 📁 Project Structure

```
HLJerusalem/
├── admin/                  # Admin panel
│   ├── assets/
│   │   └── css/
│   │       └── admin.css   # Admin-specific styles
│   ├── includes/
│   │   └── sidebar.php     # Reusable sidebar
│   ├── index.php           # Admin dashboard
│   ├── login.php           # Admin login
│   ├── logout.php          # Logout handler
│   ├── categories.php      # Category management
│   ├── products.php        # Product management
│   ├── projects.php        # Project management
│   └── settings.php        # Settings page
├── api/                    # API endpoints
│   ├── get-products.php    # Fetch products
│   └── get-projects.php    # Fetch projects
├── assets/                 # Frontend assets
│   ├── css/
│   │   └── style.css       # Main stylesheet
│   ├── js/
│   │   └── main.js         # Frontend JavaScript
│   └── images/             # Static images
├── uploads/                # User uploads
│   ├── categories/
│   ├── products/
│   └── projects/
├── config.php              # Configuration file
├── database.sql            # Database schema
├── index.php               # Homepage
└── README.md               # This file
```

## 🎨 Color Palette

The website uses a luxury color scheme:

- **Primary Gold**: `#C9A961`
- **Dark Gold**: `#A68B4E`
- **Light Gold**: `#E5D4A3`
- **Primary Brown**: `#3E2723`
- **Secondary Brown**: `#5D4037`
- **Primary Black**: `#1A1A1A`
- **Secondary Black**: `#2C2C2C`
- **Off White**: `#F5F5F0`

## 📱 Admin Panel Features

### Dashboard
- Overview statistics (categories, products, projects)
- Quick action buttons
- Direct access to all management pages

### Categories Management
- Add/Edit/Delete stone and marble categories
- Bilingual support (English & Arabic)
- Image upload for each category
- Display order customization
- Active/Inactive status control

### Products Management
- Complete product information management
- Category assignment
- Multiple images per product
- Color range specification
- Available types (Blocks, Slabs, Tiles, Cut to size)
- Featured products highlighting
- Display order control

### Projects Management
- Project portfolio management
- Location and year tracking
- Multiple project images
- Bilingual descriptions
- Display order customization

## 🌐 Frontend Sections

1. **Hero Section**: Stunning full-screen hero with company tagline
2. **About Section**: Company history and heritage since 1979
3. **Statistics**: Key numbers showcase (establishment year, quarry area, production)
4. **Global Presence**: International investments and partnerships
5. **Products**: Dynamic product showcase
6. **Projects**: Featured projects portfolio
7. **Contact**: Complete contact information with management team details

## 🔧 Customization

### Changing Colors
Edit CSS variables in `assets/css/style.css`:
```css
:root {
    --primary-gold: #C9A961;
    --primary-brown: #3E2723;
    /* ... other colors ... */
}
```

### Adding New Admin Users
```sql
INSERT INTO admin_users (username, password, email, full_name) 
VALUES ('newadmin', '$2y$10$...', 'admin@example.com', 'Admin Name');
```

Note: Use `password_hash('your_password', PASSWORD_DEFAULT)` in PHP to generate the password hash.

## 📊 Database Tables

- **categories**: Stone and marble categories
- **products**: Product listings
- **product_images**: Product image gallery
- **projects**: Project portfolio
- **project_images**: Project image gallery
- **admin_users**: Admin authentication
- **company_info**: Company information settings

## 🔒 Security Features

- Password hashing with bcrypt
- Session-based authentication
- SQL injection protection (prepared statements)
- XSS protection (output escaping)
- File upload validation
- Admin-only access control

## 🚀 Performance

- Optimized CSS with minimal dependencies
- Vanilla JavaScript (no framework overhead)
- Efficient database queries
- Image optimization recommended for uploads
- Browser caching for static assets

## 🌍 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## 📝 License

This project is proprietary software developed for H.L. Jerusalem Stone & Marble Company.

## 👨‍💻 Developer

Developed with ❤️ for H.L. Jerusalem Stone & Marble Company

## 📞 Support

For technical support or inquiries:
- **Email**: info@palstone.com
- **Phone**: +970 2 2291403

---

**H.L. Jerusalem Stone & Marble** - *Excellence in Natural Stone Since 1979*