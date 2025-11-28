@extends('layout')

@section('content')
<div class="text-center mb-16">
    <h1 class="text-5xl md:text-7xl font-bold text-stone-900 mb-4 tracking-tight">
        Policy Pulse.
    </h1>
    <p class="text-stone-500 text-lg font-light max-w-2xl mx-auto">
        Pantau respons publik terhadap 5 Kebijakan Strategis Nasional terbaru secara real-time.
    </p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
    <div class="card-warm rounded-3xl p-6 text-center">
        <div class="text-stone-400 text-xs font-bold uppercase tracking-wider mb-1">Total Data</div>
        <div class="text-3xl font-bold text-stone-800">{{ number_format($total) }}</div>
    </div>
    <div class="card-warm rounded-3xl p-6 col-span-3 flex flex-col justify-center">
        <div class="text-stone-400 text-xs font-bold uppercase tracking-wider mb-3">Indeks Sentimen Nasional</div>
        <div class="flex h-4 rounded-full overflow-hidden bg-stone-100">
            @php $sum = array_sum($stats) ?: 1; @endphp
            <div style="width: {{ ($stats['Positif']??0)/$sum*100 }}%" class="bg-emerald-500"></div>
            <div style="width: {{ ($stats['Netral']??0)/$sum*100 }}%" class="bg-stone-400"></div>
            <div style="width: {{ ($stats['Negatif']??0)/$sum*100 }}%" class="bg-rose-500"></div>
        </div>
    </div>
</div>

<!-- GRID KEBIJAKAN BARU -->
@if($policies->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    @foreach($policies as $p)
    <div class="card-warm rounded-[32px] p-8 flex flex-col justify-between h-full hover:shadow-xl transition duration-300 relative group">
        
        <div class="flex justify-between items-start mb-6">
            <div class="flex flex-col pr-12">
                <!-- TANGGAL OTOMATIS SESUAI DATA ANDA -->
                @php 
                    $date = '2025';
                    if(str_contains($p->title, 'Kemendikdasmen')) $date = '08 Feb 2025';
                    elseif(str_contains($p->title, 'IKN')) $date = '31 Jan 2025';
                    elseif(str_contains($p->title, 'Infrastruktur')) $date = '15 Jan 2025';
                    elseif(str_contains($p->title, 'Premanisme')) $date = '07 Mei 2025';
                    elseif(str_contains($p->title, 'Danantara')) $date = '28 Apr 2025';
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-stone-100 text-stone-500 text-[11px] font-bold uppercase tracking-wider mb-3 w-fit">
                    🗓 {{ $date }}
                </span>
                <h3 class="text-2xl font-bold text-stone-900 leading-tight group-hover:text-orange-600 transition">{{ $p->title }}</h3>
            </div>
            
            <!-- Tombol Link X (Satu-satunya link) -->
            @if($p->official_tweet_url)
            <a href="{{ $p->official_tweet_url }}" target="_blank" class="absolute top-8 right-8 w-10 h-10 rounded-full bg-black text-white flex items-center justify-center hover:bg-stone-700 transition shadow-lg transform hover:scale-110 z-10" title="Diskusi di X">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            @endif
        </div>

        <div class="mb-8">
            <p class="text-stone-600 text-sm leading-relaxed font-medium">
                {{ $p->description }}
            </p>
        </div>
        
        <div class="mt-auto pt-6 border-t border-stone-100 flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs text-stone-400 font-bold">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                {{ $p->tweets_count }} Replies Fetched
            </div>
            
            <a href="{{ route('policy', $p->id) }}" class="flex items-center gap-2 text-sm font-bold text-stone-900 hover:text-orange-600 transition">
                Lihat Analisis
                <span>→</span>
            </a>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection