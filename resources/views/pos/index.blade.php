@extends('layouts.pos')

@section('content')

<div class="grid grid-cols-2 gap-2 p-1"
     style="grid-auto-rows: minmax(6rem, 1fr);">

    @php
    $map = [
        'Glaces'           => 'bg-primary',
        'Crêpes & Gaufres' => 'bg-accent',
        'Chichis'          => 'bg-paper',
        'Boissons'         => 'bg-muted',
        'Café'             => 'bg-accent',
        'Sucettes'         => 'bg-primary',
    ];
    @endphp

    @foreach($categories as $cat)
        @php $bg = $map[$cat->name] ?? 'bg-primary'; @endphp
        <a href="{{ route('pos.show', $cat->id) }}"
           class="rounded-2xl border-4 border-dark {{ $bg }} flex items-center justify-center p-3 active:translate-y-1 transition-transform shadow-[4px_4px_0_#231F20]">
            <h2 class="font-black uppercase text-center text-dark font-titan leading-tight"
                style="font-size: clamp(1rem, 4vw, 2rem);">{{ $cat->name }}</h2>
        </a>
    @endforeach

</div>
@endsection