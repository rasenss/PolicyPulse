@extends('layout')

@section('content')
<div class="mb-12">
    <a href="{{ route('home') }}" class="inline-flex items-center text-stone-400 hover:text-stone-900 text-sm font-bold mb-6 transition">
        ← Kembali ke Dashboard
    </a>
    <h1 class="text-4xl md:text-5xl font-bold text-stone-900 mb-4">{{ $policy->title }}</h1>
    <p class="text-stone-500 text-lg font-light leading-relaxed max-w-3xl">{{ $policy->description }}</p>
    
    <div class="flex gap-3 mt-6">
        @if($policy->official_tweet_url)
        <a href="{{ $policy->official_tweet_url }}" target="_blank" class="bg-[#000000] text-white px-5 py-2.5 rounded-full text-sm font-bold hover:opacity-80 transition flex items-center gap-2 shadow-lg">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            Lihat Diskusi di X
        </a>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="card-warm rounded-[32px] p-8 sticky top-32">
            <h3 class="text-xs font-bold uppercase tracking-widest text-stone-400 mb-6">Analisis Sentimen</h3>
            <div class="relative aspect-square mb-8">
                <canvas id="chartDetail"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-4xl font-bold text-stone-900">{{ $policy->tweets->count() }}</span>
                    <span class="text-xs text-stone-400 uppercase tracking-wider">Opini</span>
                </div>
            </div>
            
            <div class="space-y-2">
                <div class="flex justify-between text-sm p-3 bg-stone-50 rounded-xl">
                    <span class="text-stone-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Positif</span>
                    <span class="font-bold text-stone-900">{{ $stats['Positif'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm p-3 bg-stone-50 rounded-xl">
                    <span class="text-stone-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Negatif</span>
                    <span class="font-bold text-stone-900">{{ $stats['Negatif'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm p-3 bg-stone-50 rounded-xl">
                    <span class="text-stone-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-stone-400"></span> Netral</span>
                    <span class="font-bold text-stone-900">{{ $stats['Netral'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xs font-bold uppercase tracking-widest text-stone-400">Live Feed</h3>
            <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-1 rounded font-bold">● LIVE</span>
        </div>

        <div class="space-y-4">
            @forelse($policy->tweets as $tweet)
            <div class="card-warm p-6 rounded-[24px]">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-stone-200 flex items-center justify-center font-bold text-stone-600">
                            {{ substr($tweet->username, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-stone-900">{{ $tweet->username }}</div>
                            <div class="text-xs text-stone-400">{{ \Carbon\Carbon::parse($tweet->created_at_twitter)->diffForHumans() }}</div>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide 
                        {{ $tweet->sentiment_label == 'Positif' ? 'bg-emerald-100 text-emerald-700' : 
                          ($tweet->sentiment_label == 'Negatif' ? 'bg-rose-100 text-rose-700' : 'bg-stone-100 text-stone-600') }}">
                        {{ $tweet->sentiment_label }}
                    </span>
                </div>
                <p class="text-stone-700 text-sm leading-relaxed mb-3">
                    {{ $tweet->full_text }}
                </p>
                <div class="flex gap-4 text-xs text-stone-400 font-bold">
                    <span>♥ {{ $tweet->likes }}</span>
                    <span>↻ {{ $tweet->retweets }}</span>
                </div>
            </div>
            @empty
            <div class="text-center py-12 border-2 border-dashed border-stone-200 rounded-[24px]">
                <p class="text-stone-400">Belum ada data tweet.</p>
                <p class="text-xs text-stone-400">Jalankan Python Scraper untuk mengambil data.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('chartDetail');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Positif', 'Negatif', 'Netral'],
            datasets: [{
                data: [{{ $stats['Positif'] ?? 0 }}, {{ $stats['Negatif'] ?? 0 }}, {{ $stats['Netral'] ?? 0 }}],
                backgroundColor: ['#10b981', '#f43f5e', '#a8a29e'],
                borderWidth: 0,
            }]
        },
        options: { cutout: '80%', plugins: { legend: { display: false } } }
    });
</script>
@endsection