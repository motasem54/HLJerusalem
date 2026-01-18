<aside class="admin-sidebar">
    <div class="admin-logo">
        <h2>H.L. JERUSALEM</h2>
        <p>Admin Panel</p>
    </div>
    
    <nav class="admin-nav">
        <a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>
            <span>⚇</span> Dashboard
        </a>
        <a href="categories.php" <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'class="active"' : ''; ?>>
            <span>◦</span> Categories
        </a>
        <a href="products.php" <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'class="active"' : ''; ?>>
            <span>◆</span> Products
        </a>
        <a href="projects.php" <?php echo basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'class="active"' : ''; ?>>
            <span>✦</span> Projects
        </a>
        <a href="settings.php" <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'class="active"' : ''; ?>>
            <span>⚙</span> Settings
        </a>
        <a href="logout.php" style="margin-top: auto;">
            <span>✗</span> Logout
        </a>
    </nav>
</aside>