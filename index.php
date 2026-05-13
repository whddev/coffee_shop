<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/config/db.php';

$db = getDB();

// Ambil kategori
$catStmt = $db->query("SELECT * FROM categories ORDER BY sort_order");
$categories = $catStmt->fetchAll();

// Ambil menu
$menuStmt = $db->query("
    SELECT m.*, c.slug as category_slug 
    FROM menus m 
    JOIN categories c ON m.category_id = c.id 
    WHERE m.is_available = 1 
    ORDER BY m.id
");
$allMenus = $menuStmt->fetchAll();

// Pisahkan menu per kategori
$menuByCat = [];
foreach ($allMenus as $m) {
    $menuByCat[$m['category_slug']][] = $m;
}

// Item pertama untuk display awal
$firstItem = !empty($allMenus) ? $allMenus[0] : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Toko Kopi Kawan - Kopi tetangga dari Cipete, Jakarta Selatan.">
    <title>Toko Kopi Kawan - Kopi Tetangga</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Space+Mono:wght@400;700&family=Caveat:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="tuku.css">
</head>
<body>

    <!-- ==================== HERO BANNER ==================== -->
    <section id="hero-banner" class="hero-banner">
        <div class="hero-banner__content">
            <div class="hero-banner__left">
                <div class="hero-banner__ten">
                    <span class="ten-number">1</span>
                    <div class="ten-zero">
                        <img src="images/coffee_logo.png" alt="Kawan Logo" class="ten-zero__logo">
                    </div>
                </div>
            </div>
            <div class="hero-banner__center">
                <div class="hero-banner__photos">
                    <img src="images/community_photos.png" alt="Komunitas Kawan" class="hero-banner__photo">
                </div>
                <p class="hero-banner__tagline">KAU MENYAPA<br>DAN KITA<br>BERJALAN LAGI</p>
            </div>
            <div class="hero-banner__right">
                <p class="hero-banner__anniversary">
                    <span class="chevrons">«</span> 10 TAHUN<br>LANGKAH BERSAMA
                </p>
            </div>
        </div>
    </section>

    <!-- ==================== NAVBAR ==================== -->
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <!-- ==================== SHOP INTERIOR ==================== -->
    <section id="shop-interior" class="shop-interior">
        <div class="shop-interior__overlay">
            <div class="shop-interior__sign shop-interior__sign--left">PESAN<br>DI SINI</div>
            <div class="shop-interior__sign shop-interior__sign--right">AMBIL<br>DI SINI</div>
        </div>
        <img src="images/coffee_shop_interior.png" alt="Interior Toko Kopi Kawan" class="shop-interior__img" loading="lazy">
    </section>

    <!-- ==================== TENTANG / ABOUT ==================== -->
    <section id="tentang" class="about-section">
        <div class="about-section__content">
            <h2 class="about-section__heading">BERAWAL DARI WARGA,<br>BERAKHIR JADI KELUARGA</h2>
            <div class="about-section__image-wrapper">
                <img src="images/team_photo.png" alt="Tim Kawan" class="about-section__image" loading="lazy">
            </div>
        </div>
    </section>

    <!-- ==================== PRODUK / MENU ==================== -->
    <section id="produk" class="product-section">
        <div class="product-section__left">
            <h2 class="product-section__heading">LINI PRODUK<br>TOKO KOPI KAWAN</h2>
            <img src="<?= $firstItem['image'] ?? 'images/tuku_iced_coffee.png' ?>" alt="Produk Kopi Kawan" class="product-section__image" id="product-display-img" loading="lazy">
            <div class="product-info-bar">
                <div class="product-info-bar__left">
                    <span class="menu-icon">☕</span> <span id="info-bar-title"><?= htmlspecialchars($firstItem['name'] ?? '') ?></span>
                </div>
                <div class="product-info-bar__right" id="info-bar-ingredients">
                    <?= htmlspecialchars($firstItem['ingredients'] ?? '') ?>
                </div>
            </div>
        </div>
        <div class="product-section__right">
            <div class="product-section__tabs" id="product-tabs">
                <?php foreach ($categories as $index => $cat): ?>
                <button class="product-tab <?= $index === 0 ? 'product-tab--active' : '' ?>" 
                        data-tab="<?= $cat['slug'] ?>" 
                        id="tab-<?= $cat['slug'] ?>">
                    <?= strtoupper($cat['slug']) ?>
                </button>
                <?php endforeach; ?>
            </div>
            <div class="product-section__menu" id="product-menu">
                <?php foreach ($categories as $index => $cat): ?>
                <div class="menu-grid <?= $index === 0 ? '' : 'hidden' ?>" id="menu-<?= $cat['slug'] ?>">
                    <?php 
                    $items = $menuByCat[$cat['slug']] ?? [];
                    foreach ($items as $itemIndex => $item): 
                    ?>
                    <button class="menu-item <?= ($index === 0 && $itemIndex === 0) ? 'menu-item--active' : '' ?>" 
                            data-title="<?= htmlspecialchars($item['name']) ?>" 
                            data-ingredients="<?= htmlspecialchars($item['ingredients']) ?>" 
                            data-img="<?= htmlspecialchars($item['image']) ?>">
                        <svg class="menu-icon-svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="var(--color-black)" stroke-width="2">
                            <?php if ($cat['slug'] === 'white-milk'): ?>
                                <path d="M7 6l1 15h8l1-15M6 6h12M9 2h6v4H9z"/>
                            <?php elseif ($cat['slug'] === 'black'): ?>
                                <path d="M8 4v12a4 4 0 004 4h4a4 4 0 004-4V4H8z"/><path d="M8 8H4a2 2 0 01-2-2V4h6"/>
                            <?php elseif ($cat['slug'] === 'non-coffee'): ?>
                                <path d="M6 7L8 21H16L18 7M5 7H19M7 4C9 2 15 2 17 4M12 4V1"/>
                            <?php else: ?>
                                <path d="M12 2L4 20h16L12 2z"/>
                            <?php endif; ?>
                        </svg>
                        <span class="menu-name"><?= htmlspecialchars($item['name']) ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
                <div class="menu-grid hidden" id="menu-filter"></div>
            </div>
            <div class="product-section__ingredients">
                <p class="ingredients-title">100% Biji Kopi Arabika</p>
                <div class="ingredients-grid">
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="var(--color-black)"><circle cx="12" cy="12" r="8"/></svg><span>ESPRESSO</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><path d="M7 16A4 4 0 017 8h1a5 5 0 0110 0 4 4 0 01-1 7H7z"/></svg><span>MILK FOAM</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><path d="M12 2v6m0 4a4 4 0 110 8 4 4 0 010-8z"/></svg><span>COLD DRIP</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><rect x="5" y="5" width="14" height="14" rx="2"/><path d="M5 12h14M12 5v14"/></svg><span>CHOCOLATE</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><path d="M4 12c4-8 12-8 16 0-4 4-8 4-16 0z"/></svg><span>CARAMEL SAUCE</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><circle cx="12" cy="12" r="8"/><path d="M8 8l8 8M16 8l-8 8"/></svg><span>CREAMER</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><circle cx="12" cy="12" r="8"/></svg><span>MILK</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><circle cx="12" cy="12" r="8"/><path d="M8 6v12M12 6v12M16 6v12M6 12h12"/></svg><span>ARENGA SUGAR</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><path d="M12 2C7 2 5 7 5 12c0 5 2 10 7 10 5 0 7-5 7-10 0-5-2-10-7-10z"/><path d="M12 2v20M8 12h8"/></svg><span>TEA</span></div>
                    <div class="ingredient"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-black)" stroke-width="2"><path d="M12 2l4 6-4 4-4-4 4-6zM8 12l4 6 4-6-4-4-4 4z"/></svg><span>HONEY</span></div>
                </div>
            </div>
            <div class="product-section__online">
                <p>Pembelian online melalui:</p>
                <div class="online-links">
                    <a href="#" class="online-link" id="link-gojek">Gojek</a>
                    <a href="#" class="online-link" id="link-grab">Grab</a>
                    <a href="#" class="online-link" id="link-shopee">Shopee</a>
                    <a href="#" class="online-link" id="link-tokped">Tokopedia</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="tuku.js"></script>
</body>
</html>
