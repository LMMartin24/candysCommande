@extends('layouts.pos')

@section('content')

<div class="h-full flex flex-col font-sans">

    {{-- Navbar masquée sur mobile --}}
    <header class="hidden md:flex mb-6 justify-between items-center bg-white p-4 rounded-3xl border-4 border-dark">
        <h1 class="text-3xl font-black uppercase tracking-widest text-dark">Candys</h1>
        <div class="flex items-center gap-3">
            <span class="text-sm font-bold text-gray-500 uppercase">Service</span>
            <div class="w-10 h-10 rounded-full bg-accent border-2 border-dark flex items-center justify-center font-black">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </header>

    <div class="flex-1 grid grid-cols-2 md:grid-cols-4 grid-rows-2 gap-2 md:gap-5 pos-grid">
        @foreach($categories as $index => $cat)
            @php
            $map = [
                'Glaces'         => ['bg' => 'bg-primary', 'img' => 'glace.png',   'span' => 'col-span-1 md:col-span-2 row-span-2'],
                'Crêpes & Gaufres' => ['bg' => 'bg-accent', 'img' => 'gaufre.png', 'span' => 'col-span-1 md:col-span-2 row-span-1'],
                'Chichis'        => ['bg' => 'bg-paper',   'img' => 'chichi.png',  'span' => 'col-span-1 row-span-1'],
                'Boissons'       => ['bg' => 'bg-muted',   'img' => 'boisson.png', 'span' => 'col-span-1 row-span-1'],
                'Café'           => ['bg' => 'bg-cafe',    'img' => 'cafe.png',    'span' => 'col-span-1 row-span-1'],
                'Sucettes'       => ['bg' => 'bg-accent',  'img' => 'sucettes.png','span' => 'col-span-1 row-span-1'],
            ];
            $data = $map[$cat->name] ?? ['bg' => 'bg-dark', 'img' => 'default.png', 'span' => 'col-span-1 row-span-1'];
            @endphp

            <a href="{{ route('pos.show', $cat->id) }}"
               class="group relative overflow-hidden rounded-2xl md:rounded-[30px] border-4 border-dark transition-all active:translate-y-1 h-full pos-card {{ $data['span'] }} {{ $data['bg'] }}">

                <div class="flex flex-col h-full p-2 md:p-6 bg-white/10 transition-colors group-hover:bg-white/20 rounded-xl md:rounded-[24px]">
                    {{-- Image masquée sur mobile --}}
                    <div class="hidden md:flex flex-1 items-center justify-center overflow-hidden">
                        <img src="{{ asset('img/' . $data['img']) }}"
                             alt="{{ $cat->name }}"
                             class="w-full h-full object-cover object-center opacity-90 transition-transform duration-500 group-hover:scale-110 rounded-lg">
                    </div>
                    <h2 class="text-base md:text-2xl font-black uppercase tracking-tight text-dark font-titan md:mt-4">{{ $cat->name }}</h2>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection