<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$cartCount = array_sum(array_column($_SESSION['cart'] ?? [], 'qty'));
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav id="navbar" class="navbar">
    <div class="navbar__container">
        <a href="index.php" class="navbar__logo" id="nav-logo">
            <svg class="navbar__logo-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="20" cy="20" r="18" stroke="white" stroke-width="2"/>
                <path d="M14 14 C14 14 16 12 20 12 C24 12 26 14 26 14" stroke="white" stroke-width="1.5" fill="none"/>
                <circle cx="16" cy="18" r="1.5" fill="white"/>
                <circle cx="24" cy="18" r="1.5" fill="white"/>
                <path d="M15 23 C15 23 17 26 20 26 C23 26 25 23 25 23" stroke="white" stroke-width="1.5" fill="none"/>
                <rect x="12" y="8" rx="2" width="16" height="4" stroke="white" stroke-width="1" fill="none"/>
            </svg>
            <span class="navbar__logo-text">KAWAN</span>
        </a>
        <ul class="navbar__menu" id="nav-menu">
            <li><a href="index.php#tentang" class="navbar__link <?= $currentPage==='index.php'?'':''; ?>" id="nav-tentang">TENTANG</a></li>
            <li><a href="index.php#lokasi"  class="navbar__link" id="nav-lokasi">LOKASI</a></li>
            <li><a href="galeri.php"        class="navbar__link <?= $currentPage==='galeri.php'?'navbar__link--active':''; ?>" id="nav-galeri">GALERI</a></li>
            <li>
                <a href="keranjang.php" class="navbar__cart-btn <?= $currentPage==='keranjang.php'?'navbar__cart-btn--active':''; ?>" id="nav-keranjang">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    KERANJANG
                    <span class="navbar__cart-count" id="cart-count"><?= $cartCount ?></span>
                </a>
            </li>
            <li>
                <button class="navbar__lang" id="nav-lang">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    ID <span class="chevron-down">∨</span>
                </button>
            </li>
        </ul>
        <button class="navbar__hamburger" id="nav-hamburger" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
