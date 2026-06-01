@extends('layouts.pos')

@section('content')

<div class="md:h-full flex flex-col font-sans">

    {{-- Navbar visible uniquement sur desktop portrait --}}
    <header class="hidden portrait:md:flex mb-6 justify-between items-center bg-white p-4 rounded-3xl border-4 border-dark">
        <h1 class="text-3xl font-black uppercase tracking-widest text-dark">Candys</h1>
        <div class="flex items-center gap-3">
            <span class="text-sm font-bold text-gray-500 uppercase">Service</span>
            <div class="w-10 h-10 rounded-full bg-accent border-2 border-dark flex items-center justify-center font-black">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </header>

    {{--
        Mobile (portrait + paysage) : grille 2 colonnes, hauteur auto par carte (8rem),
        défilement vertical géré par le <main> du layout.
        Desktop (md+) : grille 4 colonnes avec 2 rangées fixes qui remplissent la hauteur.
    --}}
    <div class="md:flex-1 grid gap-2 md:gap-5
                grid-cols-2 auto-rows-[8rem]
                md:grid-cols-4 md:grid-rows-2 md:auto-rows-[unset]
                pos-grid">
        @foreach($categories as $index => $cat)
            @php
            $map = [
                'Glaces'           => ['bg' => 'bg-primary', 'img' => 'glace.png',    'span' => 'md:col-span-2 md:row-span-2'],
                'Crêpes & Gaufres' => ['bg' => 'bg-accent',  'img' => 'gaufre.png',   'span' => 'md:col-span-2'],
                'Chichis'          => ['bg' => 'bg-paper',   'img' => 'chichi.png',   'span' => ''],
                'Boissons'         => ['bg' => 'bg-muted',   'img' => 'boisson.png',  'span' => ''],
                'Café'             => ['bg' => 'bg-cafe',    'img' => 'cafe.png',     'span' => ''],
                'Sucettes'         => ['bg' => 'bg-accent',  'img' => 'sucettes.png', 'span' => ''],
            ];
            $data = $map[$cat->name] ?? ['bg' => 'bg-dark', 'img' => 'default.png', 'span' => ''];
            @endphp

            <a href="{{ route('pos.show', $cat->id) }}"
               class="group relative overflow-hidden rounded-2xl md:rounded-[30px] border-4 border-dark transition-all active:translate-y-1 pos-card {{ $data['span'] }} {{ $data['bg'] }}">

                <div class="flex flex-col h-full p-2 md:p-6 bg-white/10 transition-colors group-hover:bg-white/20 rounded-xl md:rounded-[24px]">
                    {{-- Image masquée sur mobile --}}
                    <div class="hidden portrait:md:flex flex-1 items-center justify-center overflow-hidden">
                        <img src="{{ asset('img/' . $data['img']) }}"
                             alt="{{ $cat->name }}"
                             class="w-full h-full object-cover object-center opacity-90 transition-transform duration-500 group-hover:scale-110 rounded-lg">
                    </div>
                    <h2 class="text-base md:text-2xl font-black uppercase tracking-tight text-dark font-titan md:mt-4 flex items-center h-full md:h-auto">{{ $cat->name }}</h2>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection