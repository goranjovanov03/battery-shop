// Cart count update
function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const countElements = document.querySelectorAll('[data-cart-count]');
            countElements.forEach(el => {
                el.textContent = data.count;
                el.classList.toggle('hidden', data.count === 0);
            });
        });
}

// Add to cart
document.addEventListener('click', function(e) {
    const btn = e.target.closest('[data-add-to-cart]');
    if (btn) {
        e.preventDefault();
        const productId = btn.dataset.addToCart;
        const quantity = btn.dataset.quantity || 1;
        
        btn.disabled = true;
        btn.textContent = 'Adding...';
        
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ product_id: productId, quantity: parseInt(quantity) })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                updateCartCount();
                btn.textContent = 'Added!';
                setTimeout(() => {
                    btn.textContent = 'Add to Cart';
                    btn.disabled = false;
                }, 2000);
            }
        })
        .catch(() => {
            btn.textContent = 'Error';
            btn.disabled = false;
        });
    }
});

// Account dropdown
function toggleAccountMenu() {
    const dropdown = document.getElementById('account-dropdown');
    const button = document.querySelector('#account-menu button');
    
    if (dropdown && button) {
        const isOpen = !dropdown.classList.contains('hidden');
        dropdown.classList.toggle('hidden');
        button.setAttribute('aria-expanded', !isOpen);
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const menu = document.getElementById('account-menu');
    const dropdown = document.getElementById('account-dropdown');
    
    if (menu && dropdown && !menu.contains(e.target)) {
        dropdown.classList.add('hidden');
        const button = menu.querySelector('button');
        if (button) {
            button.setAttribute('aria-expanded', 'false');
        }
    }
    
    const langMenu = document.getElementById('language-menu');
    const langDropdown = document.getElementById('language-dropdown');
    
    if (langMenu && langDropdown && !langMenu.contains(e.target)) {
        langDropdown.classList.add('hidden');
        const button = langMenu.querySelector('button');
        if (button) {
            button.setAttribute('aria-expanded', 'false');
        }
    }
});

// Language dropdown
function toggleLanguageMenu() {
    const dropdown = document.getElementById('language-dropdown');
    const button = document.querySelector('#language-menu button');
    
    if (dropdown && button) {
        const isOpen = !dropdown.classList.contains('hidden');
        dropdown.classList.toggle('hidden');
        button.setAttribute('aria-expanded', !isOpen);
    }
}

// Initialize cart count
document.addEventListener('DOMContentLoaded', updateCartCount);