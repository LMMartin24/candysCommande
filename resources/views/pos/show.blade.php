@extends('layouts.pos')

@section('content')

<div class="flex flex-col gap-2 p-1" x-data="{ selectedOptions: [] }">

    {{-- Header --}}
    <header class="flex gap-2 items-center shrink-0">
        <a href="{{ route('pos.index') }}"
           class="w-10 h-10 rounded-xl bg-white border-4 border-dark flex items-center justify-center font-bold text-xl shrink-0 active:translate-y-1 transition-transform">←</a>
        <div class="flex-1 bg-white px-3 py-2 rounded-full border-4 border-dark text-center">
            <h1 class="font-black uppercase text-dark font-titan" style="font-size: clamp(1rem, 4vw, 2rem);">{{ $category->name }}</h1>
        </div>
    </header>

    {{-- Grille produits auto-adaptative --}}
    @php $colors = ['bg-primary','bg-paper','bg-accent','bg-muted']; @endphp
    <div class="grid gap-2"
         style="grid-template-columns: repeat(auto-fit, minmax(min(10rem, 45vw), 1fr)); grid-auto-rows: minmax(5rem, 1fr);">
        @foreach($products as $i => $product)
            <button @click="addItem({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->base_price }}, [...selectedOptions]); selectedOptions = []"
                    class="rounded-2xl border-4 border-dark {{ $colors[$i % 4] }} flex flex-col items-center justify-center p-3 gap-1 active:translate-y-1 transition-transform shadow-[4px_4px_0_#231F20]">
                <span class="font-black uppercase text-dark font-titan italic text-center leading-tight"
                      style="font-size: clamp(0.9rem, 3.5vw, 1.75rem);">{{ $product->name }}</span>
                <span class="bg-white/80 px-2 py-0.5 rounded-lg border-2 border-dark font-black"
                      style="font-size: clamp(0.8rem, 3vw, 1.25rem);">{{ number_format($product->base_price / 100, 2, ',', ' ') }} €</span>
            </button>
        @endforeach
    </div>

    {{-- Suppléments --}}
    @php $allOptions = $products->pluck('options')->flatten()->unique('id'); @endphp
    @if($allOptions->count() > 0)
        <div class="bg-white p-3 rounded-2xl border-4 border-dark shrink-0">
            <p class="text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Suppléments</p>
            <div class="grid gap-2"
                 style="grid-template-columns: repeat(auto-fit, minmax(min(8rem, 45vw), 1fr));">
                @foreach($allOptions as $option)
                    <button @click="const o={id:{{ $option->id }},name:'{{ addslashes($option->name) }}',additional_price:{{ $option->additional_price }}};const i=selectedOptions.findIndex(x=>x.id===o.id);i>-1?selectedOptions.splice(i,1):selectedOptions.push(o)"
                            :class="selectedOptions.find(x=>x.id==={{ $option->id }})?'bg-dark text-white':'bg-paper text-dark'"
                            class="border-4 border-dark px-2 py-2 font-black uppercase text-xs flex items-center justify-between gap-1 active:translate-y-1 transition-transform rounded-xl">
                        <span>+ {{ $option->name }}</span>
                        <span class="bg-white/50 px-1 rounded font-bold">+{{ number_format($option->additional_price / 100, 2, ',', ' ') }}€</span>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection