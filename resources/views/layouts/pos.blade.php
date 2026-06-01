<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Brasserie POS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-page text-dark font-sans overflow-hidden antialiased select-none" 
      x-data="posCart()" 
      x-init="initCart()">

    <div class="flex h-full w-full overflow-hidden flex-col md:flex-row">

        <main class="flex-1 min-h-0 p-2 md:p-6 overflow-y-auto">
            @yield('content')
        </main>

        {{-- Desktop : panneau panier complet --}}
        <aside class="hidden md:flex w-1/4 h-full bg-paper border-l-4 border-dark flex-col justify-between p-6">
            <div class="flex justify-between items-center pb-4 border-b-4 border-dark">
                <h2 class="font-black uppercase tracking-widest text-2xl font-titan">Commande</h2>
                <button @click="clearCart()" class="text-xs uppercase font-black bg-primary text-white px-4 py-2 border-2 border-dark active:translate-y-1">
                    Vider
                </button>
            </div>

            <div class="flex-1 overflow-y-auto py-6 space-y-4">
                <template x-for="(item, index) in cart" :key="item.uniqueId">
                    <div class="bg-white p-4 border-4 border-dark">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-black text-2xl font-titan">
                                    <span x-text="item.name"></span>
                                    <span x-show="item.quantity > 1" class="ml-2 bg-primary text-white text-sm px-3 py-0.5 rounded-full" x-text="'x' + item.quantity"></span>
                                </div>
                                <div class="text-lg text-gray-600 mt-1" x-text="formatCurrency(item.unit_total)"></div>
                                <template x-for="opt in item.options">
                                    <div class="text-sm text-accent font-black mt-1 uppercase">+ <span x-text="opt.name"></span></div>
                                </template>
                            </div>
                            <button @click="removeItem(index)" class="text-primary font-black text-3xl px-2 hover:scale-110">×</button>
                        </div>
                    </div>
                </template>
                <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-center opacity-40">
                    <span class="text-lg font-black uppercase tracking-wider">Panier vide</span>
                </div>
            </div>

            <div class="pt-6 border-t-4 border-dark space-y-4">
                <div class="flex justify-between items-baseline">
                    <span class="text-lg uppercase font-black">Total :</span>
                    <span class="text-4xl font-black tracking-tighter" x-text="formatTotal()">0,00 €</span>
                </div>
                <button @click="validateOrder()" :disabled="cart.length === 0"
                        class="w-full bg-accent text-dark font-black uppercase tracking-widest text-center py-4 border-4 border-dark disabled:opacity-30 transition-all hover:scale-[1.02] active:translate-y-1">
                    Valider →
                </button>
            </div>
        </aside>

        {{-- Mobile : barre basse simplifiée --}}
        <div class="md:hidden shrink-0 bg-paper border-t-4 border-dark" x-data="{ open: false }">

            {{-- Détail commande (affiché si open) --}}
            <div x-show="open" x-transition class="max-h-56 overflow-y-auto px-3 py-2 space-y-2 border-b-4 border-dark">
                <template x-for="(item, index) in cart" :key="item.uniqueId">
                    <div class="bg-white p-2 border-2 border-dark flex justify-between items-center rounded-lg">
                        <div>
                            <span class="font-black text-sm uppercase" x-text="item.name"></span>
                            <span x-show="item.quantity > 1" class="ml-1 bg-primary text-white text-xs px-2 py-0.5 rounded-full" x-text="'×' + item.quantity"></span>
                            <div class="text-xs text-gray-500" x-text="formatCurrency(item.unit_total)"></div>
                        </div>
                        <button @click="removeItem(index)" class="text-primary font-black text-2xl px-2 leading-none">×</button>
                    </div>
                </template>
                <div x-show="cart.length === 0" class="text-center text-xs font-black uppercase opacity-40 py-2">Panier vide</div>

                {{-- Boutons action dans le détail --}}
                <div x-show="cart.length > 0" class="flex gap-2 pt-1 pb-1">
                    <button @click="clearCart(); open = false"
                            class="flex-1 text-xs uppercase font-black bg-primary text-white py-2 border-2 border-dark rounded-lg active:translate-y-1">
                        Vider
                    </button>
                    <button @click="validateOrder()"
                            class="flex-1 bg-accent text-dark font-black uppercase text-xs py-2 border-4 border-dark rounded-lg active:translate-y-1">
                        Valider →
                    </button>
                </div>
            </div>

            {{-- Barre fixe : Commande + total + voir la commande --}}
            <div class="flex items-center justify-between gap-3 px-4 py-3">
                <div>
                    <p class="font-black uppercase text-xs tracking-widest text-gray-400">Commande</p>
                    <p class="font-black text-xl leading-tight" x-text="formatTotal()"></p>
                </div>
                <button @click="open = !open"
                        class="bg-accent border-4 border-dark font-black uppercase text-xs px-4 py-2 rounded-xl shadow-[3px_3px_0_#231F20] active:translate-y-1 transition-transform flex items-center gap-1">
                    <span x-text="open ? '✕ Fermer' : 'Voir la commande'"></span>
                    <span x-show="cart.length > 0" class="bg-dark text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-black" x-text="cart.length"></span>
                </button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('posCart', () => ({
            cart: [],
            initCart() {
                const savedCart = localStorage.getItem('brasserie_pos_cart');
                if (savedCart) { try { this.cart = JSON.parse(savedCart); } catch (e) { this.cart = []; } }
            },
            persist() { localStorage.setItem('brasserie_pos_cart', JSON.stringify(this.cart)); },
            addItem(id, name, basePrice, options = []) {
                let clonedOptions = JSON.parse(JSON.stringify(options));
                let optionsPrice = clonedOptions.reduce((sum, opt) => sum + parseInt(opt.additional_price), 0);
                let unitTotal = parseInt(basePrice) + optionsPrice;
                let optionString = clonedOptions.map(o => o.id).sort().join('-');
                let uniqueId = id + (optionString ? '-' + optionString : '');
                let existingItem = this.cart.find(item => item.uniqueId === uniqueId);
                if (existingItem) {
                    existingItem.quantity++;
                    existingItem.total_price = existingItem.unit_total * existingItem.quantity;
                } else {
                    this.cart.push({ uniqueId, product_id: id, name, base_price: parseInt(basePrice), options: clonedOptions, quantity: 1, unit_total: unitTotal, total_price: unitTotal });
                }
                this.persist();
            },
            removeItem(index) {
                if (this.cart[index].quantity > 1) {
                    this.cart[index].quantity--;
                    this.cart[index].total_price = this.cart[index].unit_total * this.cart[index].quantity;
                } else { this.cart.splice(index, 1); }
                this.persist();
            },
            clearCart() { this.cart = []; localStorage.removeItem('brasserie_pos_cart'); },
            formatCurrency(value) { return (value / 100).toFixed(2).replace('.', ',') + ' €'; },
            formatTotal() { return this.formatCurrency(this.cart.reduce((sum, item) => sum + item.total_price, 0)); },
            validateOrder() { console.log("Final:", JSON.stringify(this.cart)); }
        }));
    });
    </script>
</body>
</html>