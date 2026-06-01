<x-layouts.app title="Dashboard – Candys Commande">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-500 text-sm mt-1">Bienvenue sur Candys Commande 🍬</p>
    </div>

    {{-- Cartes de statistiques --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500 mb-1">Commandes du jour</p>
            <p class="text-3xl font-bold text-rose-600">0</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500 mb-1">Commandes totales</p>
            <p class="text-3xl font-bold text-rose-600">0</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500 mb-1">En attente</p>
            <p class="text-3xl font-bold text-amber-500">0</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500 mb-1">Livrées</p>
            <p class="text-3xl font-bold text-emerald-500">0</p>
        </div>
    </div>

    {{-- Dernières commandes --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800">Dernières commandes</h2>
        </div>
        <div class="px-6 py-12 text-center text-gray-400">
            <p class="text-4xl mb-3">📦</p>
            <p class="text-sm">Aucune commande pour le moment.</p>
        </div>
    </div>

</x-layouts.app>
