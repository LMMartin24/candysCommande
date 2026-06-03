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

        <main class="flex-1 min-h-0 p-2 md:p-6 overflow-y-auto flex flex-col">
            @yield('content')
        </main>

        {{-- Desktop : barre latérale + overlay plein écran --}}
        <aside class="hidden md:flex w-48 h-full bg-paper border-l-4 border-dark flex-col items-center justify-start pt-6 gap-4 shrink-0" x-data="{ open: false }">
            <p class="font-black uppercase text-xs tracking-widest text-gray-400">Commande</p>
            <p class="font-black text-3xl leading-tight" x-text="formatTotal()"></p>
            <button @click="open = true"
                    class="bg-accent border-4 border-dark font-black uppercase text-xs px-4 py-3 rounded-xl shadow-[3px_3px_0_#231F20] active:translate-y-1 transition-transform flex flex-col items-center gap-1 w-32">
                <span>Voir la commande</span>
                <span x-show="cart.length > 0" class="bg-dark text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-black" x-text="cart.length"></span>
            </button>
            @isset($backUrl)
            <a href="{{ $backUrl }}"
               class="w-32 bg-white border-4 border-dark font-black uppercase text-xs px-4 py-3 rounded-xl shadow-[3px_3px_0_#231F20] active:translate-y-1 transition-transform text-center">
                ← Retour
            </a>
            @endisset

            {{-- Overlay plein écran --}}
            <div x-show="open" x-transition
                 class="fixed inset-0 z-50 bg-paper flex flex-col">
                <div class="shrink-0 flex items-center justify-between px-6 py-4 border-b-4 border-dark">
                    <h2 class="font-black uppercase text-xl tracking-widest">Commande</h2>
                    <button @click="open = false" class="font-black text-2xl px-2 leading-none text-primary">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    <div class="grid grid-cols-2 gap-3">
                        <template x-for="(item, index) in cart" :key="item.uniqueId">
                            <div class="bg-white p-4 border-2 border-dark flex justify-between items-center rounded-lg">
                                <div>
                                    <span class="font-black text-base uppercase" x-text="item.name"></span>
                                    <span x-show="item.quantity > 1" class="ml-1 bg-primary text-white text-xs px-2 py-0.5 rounded-full" x-text="'×' + item.quantity"></span>
                                    <div class="text-sm text-gray-500" x-text="formatCurrency(item.unit_total)"></div>
                                    <template x-for="opt in item.options">
                                        <div class="text-xs text-accent font-black uppercase">+ <span x-text="opt.name"></span></div>
                                    </template>
                                </div>
                                <button @click="removeItem(index)" class="text-primary font-black text-3xl px-2 leading-none">×</button>
                            </div>
                        </template>
                    </div>
                    <div x-show="cart.length === 0" class="text-center font-black uppercase opacity-40 py-8">Panier vide</div>
                </div>
                <div class="shrink-0 px-6 py-4 border-t-4 border-dark flex justify-between items-center">
                    <span class="font-black text-2xl" x-text="formatTotal()"></span>
                    <button x-show="cart.length > 0" @click="clearCart(); open = false"
                            class="uppercase font-black bg-primary text-white px-6 py-3 border-2 border-dark rounded-lg active:translate-y-1">
                        Vider
                    </button>
                </div>
            </div>
        </aside>

        {{-- Mobile : barre basse + overlay plein écran --}}
        <div class="md:hidden shrink-0 bg-paper border-t-4 border-dark" x-data="{ open: false }">
            {{-- Barre fixe : Commande, total, bouton empilés --}}
            <div class="flex flex-col items-center py-3 gap-1">
                <p class="font-black uppercase text-xs tracking-widest text-gray-400">Commande</p>
                <p class="font-black text-2xl leading-tight" x-text="formatTotal()"></p>
                <button @click="open = true"
                        class="bg-accent border-4 border-dark font-black uppercase text-xs px-5 py-2 rounded-xl shadow-[3px_3px_0_#231F20] active:translate-y-1 transition-transform flex items-center gap-2">
                    <span>Voir la commande</span>
                    <span x-show="cart.length > 0" class="bg-dark text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-black" x-text="cart.length"></span>
                </button>
                @isset($backUrl)
                <a href="{{ $backUrl }}"
                   class="bg-white border-4 border-dark font-black uppercase text-xs px-5 py-2 rounded-xl shadow-[3px_3px_0_#231F20] active:translate-y-1 transition-transform">
                    ← Retour
                </a>
                @endisset
            </div>

            {{-- Overlay plein écran --}}
            <div x-show="open" x-transition
                 class="fixed inset-0 z-50 bg-paper flex flex-col">
                <div class="shrink-0 flex items-center justify-between px-4 py-4 border-b-4 border-dark">
                    <h2 class="font-black uppercase text-xl tracking-widest">Commande</h2>
                    <button @click="open = false" class="font-black text-2xl px-2 leading-none text-primary">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto px-4 py-3">
                    <div class="grid grid-cols-1 landscape:grid-cols-2 gap-3">
                        <template x-for="(item, index) in cart" :key="item.uniqueId">
                            <div class="bg-white p-3 border-2 border-dark flex justify-between items-center rounded-lg">
                                <div>
                                    <span class="font-black text-sm uppercase" x-text="item.name"></span>
                                    <span x-show="item.quantity > 1" class="ml-1 bg-primary text-white text-xs px-2 py-0.5 rounded-full" x-text="'×' + item.quantity"></span>
                                    <div class="text-xs text-gray-500" x-text="formatCurrency(item.unit_total)"></div>
                                </div>
                                <button @click="removeItem(index)" class="text-primary font-black text-2xl px-2 leading-none">×</button>
                            </div>
                        </template>
                    </div>
                    <div x-show="cart.length === 0" class="text-center text-sm font-black uppercase opacity-40 py-8">Panier vide</div>
                </div>
                <div class="shrink-0 px-4 py-4 border-t-4 border-dark flex justify-between items-center">
                    <span class="font-black text-2xl" x-text="formatTotal()"></span>
                    <button x-show="cart.length > 0" @click="clearCart(); open = false"
                            class="uppercase font-black bg-primary text-white px-6 py-3 border-2 border-dark rounded-lg active:translate-y-1">
                        Vider
                    </button>
                </div>
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