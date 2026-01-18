# H.L. Jerusalem Stone & Marble Company Website

![H.L. Jerusalem Logo](assets/images/logo.jpg)

## 🏛️ About The Project

A luxurious, professional website for H.L. Jerusalem Stone and Marble Company - one of Palestine's leading manufacturers and exporters of Jerusalem Gold Stone. The website features a modern design with elegant brown, black, and gold color scheme, along with a comprehensive admin dashboard for content management.

## ✨ Features

### Frontend
- **Elegant Design**: Professional interface with brown/black/gold color palette
- **Responsive Layout**: Optimized for all devices (desktop, tablet, mobile)
- **Multi-Section Homepage**:
  - Hero section with company introduction
  - Products showcase (Blocks, Slabs, Tiles, Cut to Size)
  - Company story and international branches
  - Projects gallery
  - Contact information
- **Smooth Animations**: CSS3 animations and transitions
- **SEO Optimized**: Proper meta tags and semantic HTML

### Admin Dashboard
- **Category Management**: Create, edit, delete stone/marble categories
- **Product Management**: Full CRUD operations for products
- **Image Upload**: Multiple image support for products
- **Project Gallery**: Manage showcase projects
- **Statistics Dashboard**: Overview of categories, products, and projects
- **Secure Authentication**: Login system with session management

## 🛠️ Technologies Used

- **Backend**: PHP 8.x
- **Database**: MySQL 8.x
- **Frontend**: HTML5, CSS3, JavaScript
- **Design**: Custom CSS with modern animations
- **Architecture**: MVC-inspired structure

## 📁 Project Structure

```
HLJerusalem/
│
├── admin/                    # Admin dashboard
│   ├── index.php            # Dashboard home
│   ├── login.php            # Admin authentication
│   ├── categories.php       # Category management
│   ├── products.php         # Product management
│   ├── projects.php         # Project gallery management
│   ├── logout.php           # Session logout
│   └── css/
│       └── admin.css        # Admin panel styles
│
├── includes/                 # Shared components
│   ├── config.php           # Database configuration
│   ├── header.php           # Site header
│   └── footer.php           # Site footer
│
├── assets/
│   ├── css/
│   │   └── style.css        # Main stylesheet
│   ├── js/
│   │   └── main.js          # JavaScript functionality
│   └── images/              # Image uploads
│
├── api/                      # API endpoints
│   ├── categories.php       # Category operations
│   ├── products.php         # Product operations
│   └── projects.php         # Project operations
│
├── index.php                 # Homepage
├── about.php                 # About company page
├── products.php              # Products catalog
├── projects.php              # Projects showcase
├── contact.php               # Contact information
└── database.sql              # Database schema
```

## 🚀 Installation

### Prerequisites
- PHP 8.0 or higher
- MySQL 8.0 or higher
- Apache/Nginx web server
- PHP GD extension (for image processing)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/motasem54/HLJerusalem.git
   cd HLJerusalem
   ```

2. **Create database**
   ```bash
   mysql -u root -p
   CREATE DATABASE hljerusalem;
   USE hljerusalem;
   SOURCE database.sql;
   ```

3. **Configure database connection**
   
   Edit `includes/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'hljerusalem');
   ```

4. **Set permissions**
   ```bash
   chmod 755 assets/images/
   chmod 755 admin/uploads/
   ```

5. **Access the website**
   - Frontend: `http://localhost/HLJerusalem/`
   - Admin: `http://localhost/HLJerusalem/admin/`
   - Default credentials: `admin` / `admin123` (⚠️ Change immediately!)

## 🎨 Design Philosophy

### Color Palette
- **Primary Gold**: `#C9A961` - Represents luxury and quality
- **Dark Brown**: `#3E2723` - Professional and elegant
- **Rich Black**: `#1A1A1A` - Modern and sophisticated
- **Accent Gold**: `#D4AF37` - Highlights and CTAs
- **Light Cream**: `#F5F5DC` - Backgrounds and subtle accents

### Typography
- **Headings**: 'Playfair Display' - Elegant serif font
- **Body**: 'Lato' - Clean, professional sans-serif
- **Accents**: 'Cinzel' - Luxury decorative font

## 📊 Database Schema

### Categories Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- name_en (VARCHAR 255)
- name_ar (VARCHAR 255)
- description_en (TEXT)
- description_ar (TEXT)
- image (VARCHAR 255)
- display_order (INT)
- created_at (TIMESTAMP)
```

### Products Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- category_id (INT, FOREIGN KEY)
- name_en (VARCHAR 255)
- name_ar (VARCHAR 255)
- description_en (TEXT)
- description_ar (TEXT)
- main_image (VARCHAR 255)
- created_at (TIMESTAMP)
```

### Projects Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- title_en (VARCHAR 255)
- title_ar (VARCHAR 255)
- description_en (TEXT)
- description_ar (TEXT)
- location (VARCHAR 255)
- image (VARCHAR 255)
- completed_date (DATE)
- created_at (TIMESTAMP)
```

## 🔒 Security Features

- SQL injection prevention using prepared statements
- XSS protection through input sanitization
- CSRF token implementation
- Secure session management
- Password hashing (use bcrypt/argon2)
- File upload validation
- Admin access control

## 🌐 Company Information

**H.L. Jerusalem Stone and Marble**
- **Founded**: 1979
- **Location**: Ein Sarah St. Hebron, Palestine
- **Email**: info@palstone.com
- **Phone**: +970 2 2291403
- **Fax**: +970 2 2253133

### International Branches
- 🇰🇷 **South Korea**: H.L Jerusalem Sara
- 🇹🇷 **Turkey**: H.L. Jerusalem Madencilik (990,000 m² quarry)
- 🇯🇴 **Jordan**: H.L. Jerusalem Tala Bay

### Management Team
- **General Manager**: Mr. Fahed Ghaith - 00970-599373163
- **Director Manager**: Mr. Nimer Ghaith - 00972-598881778
- **Marketing Manager**: Miss Ola Ghaith - 00970-595188753

## 📈 Production Capacity

- **Monthly Production**: 20,000 m²
- **Annual Quarry Output**: 25,000 m³
- **Production Lines**: 5 Italian advanced technology lines
- **Quarry Size (Turkey)**: 990,000 m²

## 🎯 Product Range

### Stone Types
- Jerusalem Gold Stone
- Cream Stone (various shades)
- White Stone
- Red Stone
- Grey Stone
- Yellow Stone

### Product Forms
- **Blocks**: Raw quarried blocks
- **Slabs**: Large format processed slabs
- **Tiles**: Standard and custom tile sizes
- **Cut to Size**: Custom dimensions per project

## 🚧 Roadmap

- [ ] Multi-language support (Arabic/English switcher)
- [ ] Online quotation system
- [ ] 3D stone visualizer
- [ ] Customer portal
- [ ] Product comparison tool
- [ ] Advanced search and filtering
- [ ] Export product catalogs (PDF)
- [ ] Integration with shipping calculators

## 🤝 Contributing

This is a private commercial project for H.L. Jerusalem Stone and Marble Company.

## 📝 License

Proprietary - All rights reserved by H.L. Jerusalem Stone and Marble Company © 2026

## 👨‍💻 Developer

Developed by **Motasem** - Full Stack Developer
- GitHub: [@motasem54](https://github.com/motasem54)

## 📞 Support

For technical support or inquiries:
- Email: info@palstone.com
- Phone: +970 2 2291403

---

**Made with ❤️ in Palestine** 🇵🇸