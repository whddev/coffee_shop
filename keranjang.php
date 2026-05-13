<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keranjang - Toko Kopi Kawan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Caveat:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="tuku.css">
<style>
body{background:#f4ead5}
.kr-hero{background:#4a4944;padding:60px 40px;text-align:center;position:relative;overflow:hidden}
.kr-hero::before{content:'';position:absolute;top:-50%;left:-20%;width:600px;height:600px;background:radial-gradient(circle,rgba(235,140,57,0.15),transparent 70%);pointer-events:none}
.kr-hero__title{font-family:'Caveat',cursive;font-size:72px;font-weight:700;color:#fff;line-height:1;margin-bottom:8px}
.kr-hero__sub{font-family:'Space Mono',monospace;font-size:12px;color:rgba(255,255,255,0.6);letter-spacing:3px}
.kr-main{max-width:1300px;margin:0 auto;padding:40px;display:grid;grid-template-columns:1fr 380px;gap:40px;align-items:start}
.kr-filters{display:flex;gap:12px;margin-bottom:32px;flex-wrap:wrap}
.kr-filter-btn{font-family:'Space Mono',monospace;font-size:11px;font-weight:700;letter-spacing:2px;padding:8px 20px;border:2px solid #4a4944;background:transparent;cursor:pointer;transition:all .25s;color:#1A1A1A}
.kr-filter-btn:hover,.kr-filter-btn.active{background:#4a4944;color:#fff}
.kr-filter-btn.active{background:#eb8c39;border-color:#eb8c39}
.kr-search{width:100%;padding:12px 20px;border:2px solid #4a4944;background:transparent;font-family:'Space Mono',monospace;font-size:13px;letter-spacing:1px;margin-bottom:32px;outline:none;transition:border-color .3s}
.kr-search:focus{border-color:#eb8c39}
.kr-section-title{font-family:'Caveat',cursive;font-size:32px;font-weight:700;margin-bottom:20px;padding-bottom:8px;border-bottom:2px solid #4a4944}
.kr-menu-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px;margin-bottom:40px}
.kr-card{background:#fff;border:2px solid transparent;cursor:pointer;transition:all .3s;position:relative;overflow:hidden}
.kr-card:hover{border-color:#eb8c39;transform:translateY(-4px);box-shadow:0 12px 32px rgba(235,140,57,0.2)}
.kr-card__img-placeholder{width:100%;height:160px;background:linear-gradient(135deg,#c1ab91,#bba286);display:flex;align-items:center;justify-content:center;font-size:48px}
.kr-card__body{padding:14px}
.kr-card__cat{font-family:'Space Mono',monospace;font-size:9px;letter-spacing:2px;color:#eb8c39;font-weight:700;margin-bottom:4px;text-transform:uppercase}
.kr-card__name{font-family:'Space Mono',monospace;font-size:12px;font-weight:700;letter-spacing:1px;margin-bottom:8px;line-height:1.3}
.kr-card__desc{font-size:11px;color:#666;margin-bottom:12px;line-height:1.5}
.kr-card__footer{display:flex;align-items:center;justify-content:space-between}
.kr-card__price{font-family:'Space Mono',monospace;font-size:13px;font-weight:700;color:#cf7354}
.kr-card__add{width:32px;height:32px;background:#4a4944;color:#fff;border:none;cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center;transition:background .25s}
.kr-card__add:hover{background:#eb8c39}
.kr-card__badge{position:absolute;top:10px;left:10px;background:#eb8c39;color:#fff;font-family:'Space Mono',monospace;font-size:9px;font-weight:700;letter-spacing:1px;padding:3px 8px}
.kr-empty-msg{grid-column:1/-1;text-align:center;padding:60px 20px;font-family:'Caveat',cursive;font-size:28px;color:#bba286}
.kr-cart{background:#fff;border:2px solid #4a4944;padding:28px;position:sticky;top:76px;max-height:calc(100vh - 100px);display:flex;flex-direction:column}
.kr-cart__title{font-family:'Caveat',cursive;font-size:32px;font-weight:700;margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid #4a4944;display:flex;align-items:center;gap:10px}
.kr-cart__count{background:#eb8c39;color:#fff;font-size:14px;font-family:'Space Mono',monospace;padding:2px 10px;font-weight:700}
.kr-cart__items{flex:1;overflow-y:auto;max-height:380px}
.kr-cart__items::-webkit-scrollbar{width:6px}
.kr-cart__items::-webkit-scrollbar-thumb{background:#bba286;border-radius:3px}
.kr-cart__item{display:flex;gap:12px;padding:12px 0;border-bottom:1px dashed rgba(0,0,0,.15)}
.kr-cart__item-emoji{width:52px;height:52px;background:#f4ead5;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:24px}
.kr-cart__item-info{flex:1;min-width:0}
.kr-cart__item-name{font-family:'Space Mono',monospace;font-size:11px;font-weight:700;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.kr-cart__item-price{font-size:11px;color:#cf7354;font-weight:600}
.kr-cart__item-qty{display:flex;align-items:center;gap:8px;margin-top:6px}
.kr-qty-btn{width:24px;height:24px;background:#4a4944;color:#fff;border:none;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:background .2s}
.kr-qty-btn:hover{background:#eb8c39}
.kr-qty-num{font-family:'Space Mono',monospace;font-size:12px;font-weight:700;min-width:20px;text-align:center}
.kr-cart__empty{text-align:center;padding:40px 20px;font-family:'Caveat',cursive;font-size:22px;color:#bba286;flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px}
.kr-cart__footer{border-top:2px solid #4a4944;padding-top:16px;margin-top:16px}
.kr-cart__total-row{display:flex;justify-content:space-between;font-family:'Space Mono',monospace;font-size:13px;font-weight:700;margin-bottom:16px}
.kr-cart__total-price{color:#eb8c39;font-size:18px}
.kr-cart__notes{width:100%;padding:10px;border:1px solid #4a4944;font-family:'Inter',sans-serif;font-size:12px;resize:vertical;min-height:64px;margin-bottom:16px;outline:none;background:#f4ead5}
.kr-cart__notes:focus{border-color:#eb8c39}
.kr-order-btn{width:100%;padding:16px;background:#4a4944;color:#fff;font-family:'Space Mono',monospace;font-size:13px;font-weight:700;letter-spacing:2px;border:none;cursor:pointer;transition:all .3s}
.kr-order-btn:hover{background:#eb8c39}
.kr-clear-btn{width:100%;padding:10px;background:transparent;color:#4a4944;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:2px;border:1px solid #bba286;cursor:pointer;transition:all .3s;margin-top:8px}
.kr-clear-btn:hover{border-color:#1A1A1A}
.kr-toast{position:fixed;bottom:30px;right:30px;background:#4a4944;color:#fff;padding:14px 24px;font-family:'Space Mono',monospace;font-size:12px;letter-spacing:1px;z-index:9999;transform:translateY(80px);opacity:0;transition:all .4s cubic-bezier(.175,.885,.32,1.275);pointer-events:none;border-left:4px solid #eb8c39}
.kr-toast.show{transform:translateY(0);opacity:1}
.kr-modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:500;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.kr-modal-overlay.open{opacity:1;pointer-events:all}
.kr-modal{background:#fff;max-width:500px;width:90%;padding:40px;position:relative;animation:fadeInUp .4s ease}
.kr-modal__title{font-family:'Caveat',cursive;font-size:36px;font-weight:700;margin-bottom:24px}
.kr-modal__item{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px dashed rgba(0,0,0,.1);font-size:13px}
.kr-modal__total{display:flex;justify-content:space-between;padding:16px 0 0;font-family:'Space Mono',monospace;font-size:14px;font-weight:700;color:#eb8c39;border-top:2px solid #4a4944;margin-top:8px}
.kr-modal__name-input{width:100%;padding:10px;border:1px solid #4a4944;font-family:'Inter',sans-serif;font-size:13px;margin:16px 0 8px;outline:none;background:#f4ead5}
.kr-modal__name-input:focus{border-color:#eb8c39}
.kr-modal__confirm{width:100%;padding:16px;background:#eb8c39;color:#fff;font-family:'Space Mono',monospace;font-size:13px;font-weight:700;letter-spacing:2px;border:none;cursor:pointer;margin-top:16px;transition:background .3s}
.kr-modal__confirm:hover{background:#cf7354}
.kr-modal__close{position:absolute;top:16px;right:16px;background:none;border:none;font-size:22px;cursor:pointer;color:#3A3A3A;transition:color .2s}
.kr-modal__close:hover{color:#eb8c39}
.kr-success{text-align:center;padding:40px;display:none}
.kr-success__icon{font-size:64px;margin-bottom:16px}
.kr-success__title{font-family:'Caveat',cursive;font-size:40px;font-weight:700;margin-bottom:8px;color:#eb8c39}
.kr-success__sub{font-family:'Space Mono',monospace;font-size:12px;color:#666;letter-spacing:1px;margin-bottom:24px}
.kr-success__order-id{font-family:'Space Mono',monospace;font-size:14px;font-weight:700;background:#f4ead5;padding:12px;margin-bottom:24px;border-left:4px solid #eb8c39}
.kr-success__btn{display:inline-block;padding:14px 32px;background:#4a4944;color:#fff;font-family:'Space Mono',monospace;font-size:12px;font-weight:700;letter-spacing:2px;text-decoration:none;transition:background .3s}
.kr-success__btn:hover{background:#eb8c39}
.kr-loading{text-align:center;padding:60px;font-family:'Caveat',cursive;font-size:28px;color:#bba286}
@keyframes fadeInUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
@media(max-width:900px){.kr-main{grid-template-columns:1fr;padding:20px}.kr-cart{position:static;max-height:none}.kr-hero__title{font-size:48px}}
@media(max-width:600px){.kr-menu-grid{grid-template-columns:repeat(2,1fr)}}
</style>
</head>
<body>

<?php include __DIR__ . '/includes/navbar.php'; ?>

<div class="kr-hero">
    <h1 class="kr-hero__title">KERANJANG</h1>
    <p class="kr-hero__sub">PILIH MENU FAVORITMU</p>
</div>

<div class="kr-main">
    <div class="kr-menu-section">
        <input class="kr-search" id="kr-search" type="text" placeholder="CARI MENU...">
        <div class="kr-filters" id="kr-filters">
            <button class="kr-filter-btn active" data-cat="all">SEMUA</button>
        </div>
        <div id="kr-menu-area"><div class="kr-loading">Memuat menu...</div></div>
    </div>

    <div class="kr-cart" id="kr-cart">
        <div class="kr-cart__title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            PESANAN <span class="kr-cart__count" id="kr-cart-count">0</span>
        </div>
        <div class="kr-cart__items" id="kr-cart-items">
            <div class="kr-cart__empty">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity=".3"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                Keranjang masih kosong
            </div>
        </div>
        <div class="kr-cart__footer" id="kr-cart-footer" style="display:none">
            <div class="kr-cart__total-row">
                <span>TOTAL</span>
                <span class="kr-cart__total-price" id="kr-total">Rp 0</span>
            </div>
            <textarea class="kr-cart__notes" id="kr-notes" placeholder="Catatan pesanan (opsional)..."></textarea>
            <button class="kr-order-btn" id="kr-order-btn">PESAN SEKARANG</button>
            <button class="kr-clear-btn" id="kr-clear-btn">KOSONGKAN KERANJANG</button>
        </div>
    </div>
</div>

<div class="kr-toast" id="kr-toast"></div>

<div class="kr-modal-overlay" id="kr-modal">
    <div class="kr-modal">
        <button class="kr-modal__close" id="kr-modal-close">✕</button>
        <div id="kr-modal-form">
            <h2 class="kr-modal__title">Konfirmasi Pesanan</h2>
            <div id="kr-modal-items"></div>
            <div class="kr-modal__total">
                <span>TOTAL</span><span id="kr-modal-total"></span>
            </div>
            <input class="kr-modal__name-input" id="kr-modal-name" type="text" placeholder="Nama pemesan (opsional)">
            <button class="kr-modal__confirm" id="kr-modal-confirm">✓ KONFIRMASI PESANAN</button>
        </div>
        <div class="kr-success" id="kr-success">
            <div class="kr-success__icon">✅</div>
            <div class="kr-success__title">Pesanan Masuk!</div>
            <div class="kr-success__sub">TERIMA KASIH TELAH MEMESAN</div>
            <div class="kr-success__order-id" id="kr-success-id">ORDER #???</div>
            <a href="index.php" class="kr-success__btn">KEMBALI KE BERANDA</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script>
const CAT_EMOJI = {'white-milk':'☕','black':'🖤','non-coffee':'🍵','tukudapan':'🍩'};
let menuData = [], activeCategory = 'all', searchQuery = '';

function rp(n){ return 'Rp ' + parseInt(n).toLocaleString('id-ID'); }

async function apiCall(url, options={}) {
    const r = await fetch(url, { headers: {'Content-Type':'application/json'}, ...options });
    return r.json();
}

// ---- LOAD MENU ----
async function loadMenu() {
    const data = await apiCall('api/menu.php');
    if (!data.success) { document.getElementById('kr-menu-area').innerHTML = '<div class="kr-empty-msg">Gagal memuat menu dari server.</div>'; return; }
    menuData = data.menus;
    buildFilters(data.categories);
    renderMenu();
    await refreshCart();
}

function buildFilters(cats) {
    const el = document.getElementById('kr-filters');
    cats.forEach(c => {
        const btn = document.createElement('button');
        btn.className = 'kr-filter-btn';
        btn.dataset.cat = c.slug;
        btn.textContent = c.emoji + ' ' + c.slug.replace('-',' ').toUpperCase();
        el.appendChild(btn);
    });
    el.addEventListener('click', e => {
        const btn = e.target.closest('.kr-filter-btn');
        if (!btn) return;
        document.querySelectorAll('.kr-filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeCategory = btn.dataset.cat;
        renderMenu();
    });
}

function renderMenu() {
    const area = document.getElementById('kr-menu-area');
    const cats = activeCategory === 'all' ? [...new Set(menuData.map(m=>m.category_slug))] : [activeCategory];
    let html = '';
    cats.forEach(cat => {
        const items = menuData.filter(m => m.category_slug === cat && (!searchQuery || m.name.toLowerCase().includes(searchQuery) || m.description.toLowerCase().includes(searchQuery)));
        if (!items.length) return;
        const label = {'white-milk':'☕ White-Milk Coffee','black':'🖤 Black Coffee','non-coffee':'🍵 Non Coffee','tukudapan':'🍩 Tukudapan'}[cat] || cat;
        html += `<h2 class="kr-section-title">${label}</h2><div class="kr-menu-grid">`;
        items.forEach(item => {
            html += `<div class="kr-card">
                ${item.is_popular=='1'?'<span class="kr-card__badge">FAVORIT</span>':''}
                <div class="kr-card__img-placeholder">${CAT_EMOJI[item.category_slug]||'☕'}</div>
                <div class="kr-card__body">
                    <div class="kr-card__cat">${item.category_slug.replace('-',' ')}</div>
                    <div class="kr-card__name">${item.name}</div>
                    <div class="kr-card__desc">${item.description||''}</div>
                    <div class="kr-card__footer">
                        <span class="kr-card__price">${rp(item.price)}</span>
                        <button class="kr-card__add" data-id="${item.id}" title="Tambah">+</button>
                    </div>
                </div></div>`;
        });
        html += '</div>';
    });
    if (!html) html = '<div class="kr-empty-msg">Tidak ada menu yang ditemukan 😔</div>';
    area.innerHTML = html;
    area.addEventListener('click', e => {
        const btn = e.target.closest('.kr-card__add');
        if (btn) addToCart(parseInt(btn.dataset.id));
    });
}

// ---- CART ----
async function refreshCart() {
    const data = await apiCall('api/cart.php');
    if (!data.success) return;
    renderCart(data.cart, data.total, data.count);
}

function renderCart(cart, total, count) {
    const itemsEl  = document.getElementById('kr-cart-items');
    const footerEl = document.getElementById('kr-cart-footer');
    const countEl  = document.getElementById('kr-cart-count');
    const totalEl  = document.getElementById('kr-total');
    const navCount = document.getElementById('cart-count');

    countEl.textContent = count;
    if (navCount) navCount.textContent = count;

    if (!cart.length) {
        itemsEl.innerHTML = '<div class="kr-cart__empty"><svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity=".3"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>Keranjang masih kosong</div>';
        footerEl.style.display = 'none';
        return;
    }
    footerEl.style.display = 'block';
    totalEl.textContent = rp(total);
    let html = '';
    cart.forEach(c => {
        html += `<div class="kr-cart__item">
            <div class="kr-cart__item-emoji">${CAT_EMOJI[c.category_slug]||'☕'}</div>
            <div class="kr-cart__item-info">
                <div class="kr-cart__item-name">${c.name}</div>
                <div class="kr-cart__item-price">${rp(c.price)} × ${c.qty} = ${rp(c.price*c.qty)}</div>
                <div class="kr-cart__item-qty">
                    <button class="kr-qty-btn" data-id="${c.menu_id}" data-action="dec">−</button>
                    <span class="kr-qty-num">${c.qty}</span>
                    <button class="kr-qty-btn" data-id="${c.menu_id}" data-action="inc">+</button>
                </div>
            </div></div>`;
    });
    itemsEl.innerHTML = html;
    itemsEl.querySelectorAll('.kr-qty-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id  = parseInt(btn.dataset.id);
            const act = btn.dataset.action;
            const item = cart.find(c => c.menu_id == id);
            if (!item) return;
            const newQty = act === 'inc' ? item.qty + 1 : item.qty - 1;
            updateCart(id, newQty);
        });
    });
}

async function addToCart(menuId) {
    const data = await apiCall('api/cart.php', { method:'POST', body: JSON.stringify({action:'add', menu_id: menuId, qty:1}) });
    if (data.success) { renderCart(data.cart, data.total, data.count); showToast('+ Ditambahkan ke keranjang!'); }
}

async function updateCart(menuId, qty) {
    const action = qty <= 0 ? 'remove' : 'update';
    const data = await apiCall('api/cart.php', { method:'POST', body: JSON.stringify({action, menu_id: menuId, qty}) });
    if (data.success) renderCart(data.cart, data.total, data.count);
}

async function clearCart() {
    const data = await apiCall('api/cart.php', { method:'POST', body: JSON.stringify({action:'clear'}) });
    if (data.success) renderCart(data.cart, data.total, data.count);
}

// ---- ORDER ----
function openModal() {
    const cartItems = document.querySelectorAll('.kr-cart__item');
    const totalText = document.getElementById('kr-total').textContent;
    const modal = document.getElementById('kr-modal');
    const itemsEl = document.getElementById('kr-modal-items');
    itemsEl.innerHTML = '';
    cartItems.forEach(el => {
        const name = el.querySelector('.kr-cart__item-name').textContent;
        const price = el.querySelector('.kr-cart__item-price').textContent.split('=')[1]?.trim() || '';
        const row = document.createElement('div');
        row.className = 'kr-modal__item';
        row.innerHTML = `<span>${name}</span><span>${price}</span>`;
        itemsEl.appendChild(row);
    });
    document.getElementById('kr-modal-total').textContent = totalText;
    document.getElementById('kr-modal-form').style.display = 'block';
    document.getElementById('kr-success').style.display = 'none';
    modal.classList.add('open');
}

async function confirmOrder() {
    const name  = document.getElementById('kr-modal-name').value.trim();
    const notes = document.getElementById('kr-notes').value.trim();
    const btn   = document.getElementById('kr-modal-confirm');
    btn.disabled = true;
    btn.textContent = 'Memproses...';

    const data = await apiCall('api/order.php', { method:'POST', body: JSON.stringify({customer_name: name, notes}) });
    btn.disabled = false;
    btn.textContent = '✓ KONFIRMASI PESANAN';

    if (data.success) {
        document.getElementById('kr-success-id').textContent = 'ORDER #' + data.order_id;
        document.getElementById('kr-modal-form').style.display = 'none';
        document.getElementById('kr-success').style.display = 'block';
        renderCart([], 0, 0);
        if (document.getElementById('cart-count')) document.getElementById('cart-count').textContent = '0';
    } else {
        showToast('❌ Gagal: ' + (data.error || 'Coba lagi'));
    }
}

function showToast(msg) {
    const t = document.getElementById('kr-toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2500);
}

document.getElementById('kr-order-btn').addEventListener('click', openModal);
document.getElementById('kr-modal-close').addEventListener('click', () => document.getElementById('kr-modal').classList.remove('open'));
document.getElementById('kr-modal').addEventListener('click', e => { if(e.target===e.currentTarget) e.currentTarget.classList.remove('open'); });
document.getElementById('kr-modal-confirm').addEventListener('click', confirmOrder);
document.getElementById('kr-clear-btn').addEventListener('click', () => { if(confirm('Kosongkan semua item?')) clearCart(); });
document.getElementById('kr-search').addEventListener('input', e => { searchQuery = e.target.value.toLowerCase().trim(); renderMenu(); });

loadMenu();
</script>
</body>
</html>
