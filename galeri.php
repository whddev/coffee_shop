<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Galeri Toko Kopi Kawan - Kegiatan dan Momen Bersama Tetangga">
    <title>Galeri - Toko Kopi Kawan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Space+Mono:wght@400;700&family=Caveat:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="tuku.css">
    <style>
        body { background: #B55A2A; }
        .gallery-hero { padding: 60px 60px 30px; text-align: center; }
        .gallery-hero__taglines { display: flex; flex-direction: column; align-items: flex-start; max-width: 600px; margin: 0 auto 24px; padding-left: 60px; }
        .gallery-hero__taglines span { font-family: 'Playfair Display', serif; font-style: italic; font-size: 18px; color: rgba(255,255,255,0.85); line-height: 2; }
        .gallery-hero__taglines span:nth-child(2) { margin-left: 40px; }
        .gallery-hero__taglines span:nth-child(3) { margin-left: 80px; }
        .gallery-hero__heading { font-family: 'Caveat', cursive; font-size: 64px; font-weight: 700; color: #ffffff; line-height: 1; margin-bottom: 30px; }
        .gallery-hero__heading em { font-style: italic; color: #E8873A; font-size: 72px; }
        .gallery-tabs { display: flex; justify-content: center; margin-bottom: 50px; }
        .gallery-tab { font-family: 'Space Mono', monospace; font-size: 13px; font-weight: 700; letter-spacing: 2px; padding: 10px 40px; border: 2px solid #ffffff; background: transparent; color: #ffffff; cursor: pointer; transition: all 0.2s; }
        .gallery-tab:first-child { border-right: none; }
        .gallery-tab--active { background: #E8873A; border-color: #E8873A; color: #ffffff; }
        .gallery-grid { max-width: 1100px; margin: 0 auto; padding: 0 40px 80px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px 20px; align-items: start; }
        .polaroid { background: #ffffff; padding: 12px 12px 40px; box-shadow: 4px 8px 24px rgba(0,0,0,0.25); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
        .polaroid:hover { box-shadow: 8px 16px 40px rgba(0,0,0,0.35); z-index: 10; transform: scale(1.05) rotate(0deg) !important; }
        .polaroid:nth-child(1) { transform: rotate(-4deg); }
        .polaroid:nth-child(2) { transform: rotate(2deg) translateY(20px); }
        .polaroid:nth-child(3) { transform: rotate(-2deg) translateY(10px); }
        .polaroid:nth-child(4) { transform: rotate(3deg); }
        .polaroid:nth-child(5) { transform: rotate(2deg) translateY(-10px); }
        .polaroid:nth-child(6) { transform: rotate(-3deg) translateY(15px); }
        .polaroid:nth-child(7) { transform: rotate(1deg); }
        .polaroid:nth-child(8) { transform: rotate(-2deg) translateY(5px); }
        .polaroid__img { width: 100%; aspect-ratio: 1/1; object-fit: cover; background: #ccc; display: block; }
        .polaroid__footer { padding-top: 10px; }
        .polaroid__category { font-family: 'Caveat', cursive; font-size: 11px; color: #888; display: block; margin-bottom: 2px; }
        .polaroid__title { font-family: 'Caveat', cursive; font-size: 16px; font-weight: 700; color: #1a1a1a; line-height: 1.2; }
        .gallery-content { display: none; }
        .gallery-content.active { display: grid; }
        @media(max-width: 900px) { .gallery-grid { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>

    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <div class="gallery-hero">
        <div class="gallery-hero__taglines">
            <span>Berangan,</span>
            <span>Berkarya,</span>
            <span>Bertumbuh,</span>
        </div>
        <h1 class="gallery-hero__heading">Bersama <em>KAWAN.</em></h1>

        <div class="gallery-tabs">
            <button class="gallery-tab gallery-tab--active" data-tab="kegiatan">KEGIATAN</button>
            <button class="gallery-tab" data-tab="toko">TOKO</button>
        </div>
    </div>

    <!-- GALLERY KEGIATAN -->
    <div class="gallery-grid gallery-content active" id="gallery-kegiatan">
        <div class="polaroid">
            <img class="polaroid__img" src="images/community_photos.png" alt="Ulang Tahun ke-9">
            <div class="polaroid__footer">
                <span class="polaroid__category">Kegiatan</span>
                <p class="polaroid__title">Ulang Tahun ke-10</p>
            </div>
        </div>
        <div class="polaroid">
            <img class="polaroid__img" src="images/coffee_shop_interior.png" alt="Sapa Barista Lama">
            <div class="polaroid__footer">
                <span class="polaroid__category">Kegiatan</span>
                <p class="polaroid__title">Sapa Barista Lama</p>
            </div>
        </div>
        <div class="polaroid">
            <img class="polaroid__img" src="images/team_photo.png" alt="Bertamu ke Bandung">
            <div class="polaroid__footer">
                <span class="polaroid__category">Kegiatan</span>
                <p class="polaroid__title">Bertamu ke Lumajang</p>
            </div>
        </div>
        <div class="polaroid">
            <img class="polaroid__img" src="images/coffee_exterior.png" alt="Kumpul Tetangga">
            <div class="polaroid__footer">
                <span class="polaroid__category">Kegiatan</span>
                <p class="polaroid__title">Kumpul Kawan</p>
            </div>
        </div>
    </div>

    <!-- GALLERY TOKO -->
    <div class="gallery-grid gallery-content" id="gallery-toko">
        <div class="polaroid">
            <img class="polaroid__img" src="images/coffee_exterior.png" alt="Kawan Lumajang">
            <div class="polaroid__footer">
                <span class="polaroid__category">Toko</span>
                <p class="polaroid__title">Kawan Lumajang</p>
            </div>
        </div>
        <div class="polaroid">
            <img class="polaroid__img" src="images/coffee_shop_interior.png" alt="Suasana Pagi">
            <div class="polaroid__footer">
                <span class="polaroid__category">Toko</span>
                <p class="polaroid__title">Suasana Pagi</p>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script>
        const tabs = document.querySelectorAll('.gallery-tab');
        const contents = document.querySelectorAll('.gallery-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('gallery-tab--active'));
                tab.classList.add('gallery-tab--active');
                const target = tab.dataset.tab;
                contents.forEach(c => {
                    c.classList.remove('active');
                    if (c.id === 'gallery-' + target) c.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
