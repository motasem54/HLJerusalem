<?php
require_once 'config/config.php';
require_once 'includes/header.php';

// Get category filter
$category_filter = isset($_GET['category']) ? sanitize($_GET['category']) : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = ITEMS_PER_PAGE;
$offset = ($page - 1) * $per_page;

// Get categories for filter
$stmt = $db->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order ASC");
$categories = $stmt->fetchAll();

// Build query
$where = "WHERE p.is_active = 1";
if ($category_filter) {
    $where .= " AND c.slug = '" . $category_filter . "'";
}

// Get total count
$count_query = "SELECT COUNT(*) as total FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                $where";
$total = $db->query($count_query)->fetch()['total'];
$total_pages = ceil($total / $per_page);

// Get products
$query = "SELECT p.*, c.name_en as category_name, c.slug as category_slug 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          $where 
          ORDER BY p.display_order ASC, p.created_at DESC 
          LIMIT $per_page OFFSET $offset";
$products = $db->query($query)->fetchAll();
?>

<!-- Page Header -->
<section class="page-header" style="margin-top: 80px; background: linear-gradient(135deg, #1A1A1A 0%, #3E2F1F 100%); padding: 60px 0; color: #fff; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; color: #D4AF37; margin-bottom: 15px;">Our Products</h1>
        <p style="font-size: 18px; color: #F5F5DC;">Blocks, Slabs, Tiles, and Cut to Size</p>
    </div>
</section>

<!-- Products Filter -->
<section style="padding: 40px 0; background: #F8F8F8;">
    <div class="container">
        <div style="display: flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
            <a href="products.php" 
               class="filter-btn <?= !$category_filter ? 'active' : '' ?>" 
               style="padding: 12px 30px; background: <?= !$category_filter ? '#D4AF37' : '#fff' ?>; color: <?= !$category_filter ? '#1A1A1A' : '#666' ?>; border: 2px solid #D4AF37; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                All Products
            </a>
            <?php foreach ($categories as $cat): ?>
            <a href="products.php?category=<?= $cat['slug'] ?>" 
               class="filter-btn <?= $category_filter == $cat['slug'] ? 'active' : '' ?>"
               style="padding: 12px 30px; background: <?= $category_filter == $cat['slug'] ? '#D4AF37' : '#fff' ?>; color: <?= $category_filter == $cat['slug'] ? '#1A1A1A' : '#666' ?>; border: 2px solid #D4AF37; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                <?= $cat['name_en'] ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section style="padding: 80px 0;">
    <div class="container">
        <?php if (count($products) > 0): ?>
        <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 35px;">
            <?php foreach ($products as $product): ?>
            <div class="product-card" style="background: #fff; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.3s;">
                <div style="position: relative; overflow: hidden; height: 350px;">
                    <?php if ($product['main_image']): ?>
                        <img src="<?= UPLOAD_URL ?>/products/<?= $product['main_image'] ?>" 
                             alt="<?= $product['name_en'] ?>"
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                    <?php else: ?>
                        <img src="assets/images/product-placeholder.jpg" 
                             alt="<?= $product['name_en'] ?>"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    <?php endif; ?>
                    <div style="position: absolute; top: 15px; right: 15px; background: #D4AF37; color: #1A1A1A; padding: 5px 15px; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                        <?= str_replace('_', ' ', $product['product_type']) ?>
                    </div>
                </div>
                <div style="padding: 25px;">
                    <div style="font-size: 13px; color: #D4AF37; margin-bottom: 8px; font-weight: 600;">
                        <?= $product['category_name'] ?>
                    </div>
                    <h3 style="font-size: 22px; color: #5D4E37; margin-bottom: 12px;"><?= $product['name_en'] ?></h3>
                    <?php if ($product['description_en']): ?>
                    <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 15px;">
                        <?= substr($product['description_en'], 0, 120) ?>...
                    </p>
                    <?php endif; ?>
                    <?php if ($product['color']): ?>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <span style="font-size: 13px; color: #999;">Color:</span>
                        <span style="font-weight: 600; color: #5D4E37;"><?= $product['color'] ?></span>
                    </div>
                    <?php endif; ?>
                    <a href="product-detail.php?slug=<?= $product['slug'] ?>" 
                       style="display: inline-block; padding: 10px 25px; background: transparent; color: #D4AF37; border: 2px solid #D4AF37; font-weight: 600; text-decoration: none; transition: all 0.3s;">
                        View Details
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div style="margin-top: 60px; text-align: center;">
            <div style="display: inline-flex; gap: 10px;">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?><?= $category_filter ? '&category=' . $category_filter : '' ?>" 
                   style="padding: 10px 20px; background: <?= $i == $page ? '#D4AF37' : '#fff' ?>; color: <?= $i == $page ? '#1A1A1A' : '#666' ?>; border: 2px solid #D4AF37; text-decoration: none; font-weight: 600;">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div style="text-align: center; padding: 60px 20px;">
            <h3 style="font-size: 24px; color: #666;">No products found</h3>
            <p style="color: #999; margin-top: 10px;">Please check back later or contact us for custom orders</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>