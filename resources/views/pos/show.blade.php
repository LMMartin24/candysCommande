@extends('layouts.pos')

@section('content')

<div class="h-full flex flex-col font-sans" x-data="{ selectedOptions: [] }">
    
    <header class="mb-6 flex gap-4 items-center">
        <a href="{{ route('pos.index') }}" 
           class="w-16 h-16 rounded-2xl bg-white border-4 border-dark   flex items-center justify-center text-3xl font-bold hover:bg-paper transition-colors">
            ←
        </a>
        <div class="flex-1 bg-white p-4 rounded-full border-4 border-[#231F20]  ">
            <h1 class="text-3xl font-black uppercase tracking-widest text-dark font-titan text-center">
                {{ $category->name }}
            </h1>
        </div>
    </header>

    <div class="flex-1 grid grid-cols-2 gap-8 pos-grid">
        
        @php
            $imgMap = ['Glaces'=>'glace.png', 'Crêpes & Gaufres'=>'gaufre.png', 'Chichis'=>'chichi.png', 'Boissons'=>'boisson.png', 'Café'=>'cafe.png', 'Sucettes'=>'sucettes.png'];
            $img = $imgMap[$category->name] ?? 'default.png';
        @endphp
        <div class="rounded-[40px] border-4 border-dark transition-colors overflow-hidden h-full">
            <div class="flex flex-col h-full p-6 bg-white/10 rounded-[30px]">
                <h2 class="text-2xl font-black uppercase tracking-tight text-dark font-titan mb-4">{{ $category->name }}</h2>

                <div class="flex-1 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('img/' . $img) }}" alt="{{ $category->name }}" class="w-full h-full object-cover object-center rounded-lg transition-transform duration-500 group-hover:scale-110">
                </div>
            </div>
        </div>

        <div class="flex flex-col h-full min-h-0">
            <div class="flex-1 min-h-0 overflow-hidden pr-2 grid gap-5" style="grid-template-rows: repeat({{ max(1, $products->count()) }}, minmax(0, 1fr));">
                @php $colorClasses = ['bg-primary', 'bg-paper', 'bg-accent', 'bg-muted']; @endphp
                @foreach($products as $index => $product)
                    <button
                        @click="addItem({{ $product->id }}, '{{ $product->name }}', {{ $product->base_price }}, [...selectedOptions]); selectedOptions = []"
                        class="w-full h-full flex items-stretch justify-between p-6 rounded-[30px] border-4 border-dark shadow-[6px_6px_0px_0px_#231F20] transition-all hover:-translate-y-1 active:translate-y-1 {{ $colorClasses[$index % 4] }}">

                        <span class="flex items-center text-3xl font-black uppercase text-dark font-titan italic">
                            {{ $product->name }}
                        </span>
                        <span class="text-3xl font-black bg-white/80 px-6 py-0 flex items-center h-full rounded-2xl border-4 border-dark">
                            {{ number_format($product->base_price / 100, 2, ',', ' ') }} €
                        </span>
                    </button>
                @endforeach
            </div>

            @php $allOptions = $products->pluck('options')->flatten()->unique('id'); @endphp
            @if($allOptions->count() > 0)
                <div class="mt-4 shrink-0 bg-white p-6 rounded-[30px] border-4 border-dark shadow-[6px_6px_0px_0px_#231F20] flex flex-col">
                    <h4 class="text-sm font-black uppercase text-gray-400 mb-4 tracking-[0.2em]">Supplements</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 flex-1 min-h-0 auto-rows-fr">
                        @foreach($allOptions as $option)
                            <button 
                                @click="
                                    const opt = {id: {{ $option->id }}, name: '{{ $option->name }}', additional_price: {{ $option->additional_price }} };
                                    const idx = selectedOptions.findIndex(o => o.id === opt.id);
                                    idx > -1 ? selectedOptions.splice(idx, 1) : selectedOptions.push(opt);
                                "
                                :class="selectedOptions.find(o => o.id === {{ $option->id }}) ? 'bg-dark text-white' : 'bg-paper text-dark'"
                                class="h-full w-full flex items-center justify-between gap-3 border-4 border-dark px-5 py-3 font-black uppercase text-sm shadow-[3px_3px_0px_0px_#231F20] transition-all">
                                <span>+ {{ $option->name }}</span>
                                <span class="bg-white/50 px-2 py-0.5 rounded text-xs">+{{ number_format($option->additional_price / 100, 2, ',', ' ') }}€</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection