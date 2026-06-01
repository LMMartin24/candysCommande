import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// resources/js/app.js

document.addEventListener('alpine:init', () => {
    Alpine.data('posCart', () => ({
        cart: [],

        initCart() {
            if (localStorage.getItem('brasserie_cart')) {
                this.cart = JSON.parse(localStorage.getItem('brasserie_cart'));
            }
        },

        saveCart() {
            localStorage.setItem('brasserie_cart', JSON.stringify(this.cart));
            
            // ⚡ Synchronisation en arrière-plan avec l'écran meuble
            fetch('/pos/sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    items: this.cart,
                    total: this.calculateTotal()
                })
            });
        },

        addItem(productId, name, basePrice, options = []) {
            const uniqueId = Date.now() + Math.random().toString(36).substr(2, 9);
            this.cart.push({ uniqueId, product_id: productId, name, base_price: parseInt(basePrice), quantity: 1, options });
            this.saveCart();
        },

        removeItem(index) {
            this.cart.splice(index, 1);
            this.saveCart();
        },

        clearCart() {
            this.cart = [];
            this.saveCart();
        },

        calculateTotal() {
            return this.cart.reduce((total, item) => {
                const optionsSum = item.options.reduce((sum, opt) => sum + opt.additional_price, 0);
                return total + (item.base_price + optionsSum) * item.quantity;
            }, 0);
        },

        formatCurrency(amountInCents) {
            return (amountInCents / 100).toFixed(2).replace('.', ',') + ' €';
        },

        formatTotal() {
            return this.formatCurrency(this.calculateTotal());
        },

        // Validation réelle de la commande
        validateOrder() {
            fetch('/pos/validate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    items: this.cart,
                    total: this.calculateTotal()
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    this.clearCart();
                    window.location.href = '/pos';
                }
            });
        }
    }));
});
