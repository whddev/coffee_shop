// ===== Cart Count from PHP Session API =====
async function updateCartCount() {
    try {
        const response = await fetch('api/cart.php');
        const data = await response.json();
        const total = data.count || 0;
        const el = document.getElementById('cart-count');
        if (el) {
            el.textContent = total;
        }
    } catch (e) {
        console.error('Gagal update cart count:', e);
    }
}
updateCartCount();
// Sinkronisasi berkala atau saat pindah tab
window.addEventListener('focus', updateCartCount);

// ===== Sticky Navbar =====
const navbar = document.getElementById('navbar');
const heroHeight = document.getElementById('hero-banner').offsetHeight;

window.addEventListener('scroll', () => {
    if (window.scrollY >= heroHeight) {
        navbar.classList.add('navbar--sticky');
    } else {
        navbar.classList.remove('navbar--sticky');
    }
});

// ===== Mobile Hamburger =====
const hamburger = document.getElementById('nav-hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('navbar__menu--open');
});

// ===== Product Tabs =====
const tabs = document.querySelectorAll('.product-tab');
const menuGrids = document.querySelectorAll('.menu-grid:not(#menu-filter)');
const filterGrid = document.getElementById('menu-filter');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('product-tab--active'));
        tab.classList.add('product-tab--active');
        
        // Remove ingredient active states
        document.querySelectorAll('.ingredient').forEach(el => el.classList.remove('active'));
        
        const target = tab.dataset.tab;
        
        if (filterGrid) filterGrid.classList.add('hidden');
        
        menuGrids.forEach(grid => {
            grid.classList.add('hidden');
            if (grid.id === 'menu-' + target) {
                grid.classList.remove('hidden');
                grid.style.animation = 'fadeIn 0.4s ease';
                // Auto-select first item
                const firstItem = grid.querySelector('.menu-item');
                if (firstItem) firstItem.click();
            }
        });
    });
});

// ===== Product Item Selection =====
const allOriginalItems = Array.from(document.querySelectorAll('.menu-item'));
const infoBarTitle = document.getElementById('info-bar-title');
const infoBarIngredients = document.getElementById('info-bar-ingredients');
const productImage = document.getElementById('product-display-img');
const infoBarLeftIcon = document.querySelector('.product-info-bar__left .menu-icon');

function selectMenuItem(item) {
    // Remove active from all visible menu items
    document.querySelectorAll('.menu-item--active').forEach(act => act.classList.remove('menu-item--active'));
    item.classList.add('menu-item--active');
    
    const title = item.getAttribute('data-title');
    const ingredients = item.getAttribute('data-ingredients');
    const imgSrc = item.getAttribute('data-img');
    const svgIcon = item.querySelector('svg');
    
    // Update info bar title
    const titleEl = document.getElementById('info-bar-title');
    const ingredientsEl = document.getElementById('info-bar-ingredients');
    if (titleEl) titleEl.textContent = title || '';
    if (ingredientsEl) ingredientsEl.textContent = ingredients || '';
    
    // Copy the exact SVG to the bottom info bar
    const iconEl = document.querySelector('.product-info-bar__left .menu-icon');
    if (iconEl) {
        if (svgIcon) {
            iconEl.innerHTML = svgIcon.outerHTML;
        } else {
            iconEl.innerHTML = '☕';
        }
    }
    
    // Update the product image with smooth transition
    const imgEl = document.getElementById('product-display-img');
    if (imgEl && imgSrc) {
        imgEl.style.opacity = '0';
        imgEl.style.transition = 'opacity 0.3s ease';
        imgEl.onerror = () => { 
            imgEl.src = 'images/tuku_iced_coffee.png'; 
            imgEl.style.opacity = '1';
        };
        imgEl.src = imgSrc;
        imgEl.onload = () => { imgEl.style.opacity = '1'; };
    }
}

// Bind original items
allOriginalItems.forEach(item => {
    item.addEventListener('click', () => selectMenuItem(item));
});

// ===== Ingredient Filter =====
document.querySelectorAll('.ingredient').forEach(ingBtn => {
    ingBtn.addEventListener('click', () => {
        const targetIngredient = ingBtn.querySelector('span').textContent.trim();
        
        // Remove active from tabs
        tabs.forEach(t => t.classList.remove('product-tab--active'));
        
        // Hide normal grids
        menuGrids.forEach(g => g.classList.add('hidden'));
        
        // Clear and prepare filter grid
        if (filterGrid) {
            filterGrid.innerHTML = '';
            
            // Find matches across ALL items
            const matches = allOriginalItems.filter(item => {
                const ing = item.getAttribute('data-ingredients') || "";
                return ing.includes(targetIngredient);
            });
            
            // Append clones and bind click
            matches.forEach(match => {
                const clone = match.cloneNode(true);
                clone.addEventListener('click', () => selectMenuItem(clone));
                filterGrid.appendChild(clone);
            });
            
            filterGrid.classList.remove('hidden');
            filterGrid.style.animation = 'fadeIn 0.4s ease';
            
            // Remove active from all ingredients, and highlight the clicked one specifically
            document.querySelectorAll('.ingredient').forEach(el => el.classList.remove('active'));
            ingBtn.classList.add('active');
        }
    });
});

// Initialize the first item
const firstActiveItem = document.querySelector('.menu-item--active');
if (firstActiveItem) {
    firstActiveItem.click();
}

// ===== Merchandise Modal =====
const merchCards = document.querySelectorAll('.merch-card');
const merchModal = document.getElementById('merch-modal');
const merchModalOverlay = document.getElementById('merch-modal-overlay');
const merchModalClose = document.getElementById('merch-modal-close');

const mTitle = document.getElementById('merch-modal-title');
const mPrice = document.getElementById('merch-modal-price');
const mDesc = document.getElementById('merch-modal-desc');
const mImg = document.getElementById('merch-modal-img');
const mThumb = document.getElementById('merch-modal-thumb');

merchCards.forEach(card => {
    card.addEventListener('click', () => {
        const title = card.querySelector('h4').textContent;
        const price = card.querySelector('.merch-price').textContent;
        const desc = card.getAttribute('data-description') || 'Produk berkualitas dari Toko Kopi Kawan untuk tetangga.';
        const imgSrc = card.querySelector('img').src;
        
        mTitle.textContent = title;
        mPrice.textContent = price;
        mDesc.textContent = desc;
        mImg.src = imgSrc;
        mThumb.src = imgSrc;
        
        merchModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});

const closeModal = () => {
    merchModal.classList.remove('active');
    document.body.style.overflow = '';
};

if (merchModalClose) merchModalClose.addEventListener('click', closeModal);
if (merchModalOverlay) merchModalOverlay.addEventListener('click', closeModal);

