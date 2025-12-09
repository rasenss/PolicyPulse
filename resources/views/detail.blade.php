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
    {{-- Sidebar Stats --}}
    <div class="lg:col-span-1">
        <div class="card-warm rounded-[32px] p-8 sticky top-32">
            <h3 class="text-xs font-bold uppercase tracking-widest text-stone-400 mb-6">Analisis Sentimen</h3>
            <div class="relative aspect-square mb-8">
                <canvas id="chartDetail"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-4xl font-bold text-stone-900">{{ $policy->tweets->count() }}</span>
                    <span class="text-xs text-stone-400 uppercase tracking-wider">Total Opini</span>
                </div>
            </div>
            
            {{-- Filter Buttons --}}
            <div class="space-y-2 mb-4">
                <button class="filter-btn w-full flex justify-between text-sm p-3 bg-stone-50 rounded-xl cursor-pointer hover:bg-emerald-50 transition text-left" data-filter="Positif">
                    <span class="text-stone-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Positif</span>
                    <span class="font-bold text-stone-900">{{ $stats['Positif'] ?? 0 }}</span>
                </button>
                <button class="filter-btn w-full flex justify-between text-sm p-3 bg-stone-50 rounded-xl cursor-pointer hover:bg-rose-50 transition text-left" data-filter="Negatif">
                    <span class="text-stone-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Negatif</span>
                    <span class="font-bold text-stone-900">{{ $stats['Negatif'] ?? 0 }}</span>
                </button>
                <button class="filter-btn w-full flex justify-between text-sm p-3 bg-stone-50 rounded-xl cursor-pointer hover:bg-stone-100 transition text-left" data-filter="Netral">
                    <span class="text-stone-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-stone-400"></span> Netral</span>
                    <span class="font-bold text-stone-900">{{ $stats['Netral'] ?? 0 }}</span>
                </button>
            </div>

            <button id="showAllBtn" class="w-full py-3 text-sm font-bold text-white bg-stone-900 hover:bg-orange-600 rounded-xl transition">
                Tampilkan Semua ({{ $policy->tweets->count() }})
            </button>

            {{-- Analysis Method Info --}}
            <div class="mt-6 pt-6 border-t border-stone-200">
                <h4 class="text-xs font-bold uppercase tracking-widest text-stone-400 mb-3">Metode Analisis</h4>
                <div class="text-xs text-stone-500 space-y-1">
                    <p>• LDA Topic Modeling</p>
                    <p>• Hybrid Lexicon-SVM</p>
                    <p>• Contextual Analysis</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content - Tweets/Replies --}}
    <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-stone-400">Semua Opini Publik</h3>
                <p class="text-sm text-stone-500 mt-1" id="filterStatus">Menampilkan <span id="visibleCount">{{ $policy->tweets->count() }}</span> dari {{ $policy->tweets->count() }} opini</p>
            </div>
            <div class="flex items-center gap-3">
                <select id="sortSelect" class="text-xs bg-stone-100 border-0 rounded-lg px-3 py-2 font-bold text-stone-600 cursor-pointer">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="likes">Paling Disukai</option>
                    <option value="retweets">Paling Banyak RT</option>
                </select>
                <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-1 rounded font-bold">● LIVE</span>
            </div>
        </div>

        {{-- Search Box --}}
        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Cari dalam opini..." 
                class="w-full px-4 py-3 rounded-xl bg-stone-100 border-0 text-sm focus:ring-2 focus:ring-orange-500 transition">
        </div>

        {{-- Tweets Container --}}
        <div class="space-y-4" id="tweetsContainer">
            @forelse($policy->tweets as $tweet)
            <div class="tweet-card card-warm p-6 rounded-[24px] transition-all duration-300" 
                 data-sentiment="{{ $tweet->sentiment_label }}"
                 data-likes="{{ $tweet->likes }}"
                 data-retweets="{{ $tweet->retweets }}"
                 data-date="{{ strtotime($tweet->created_at_twitter) }}">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-stone-300 to-stone-400 flex items-center justify-center font-bold text-white text-sm">
                            {{ strtoupper(substr($tweet->username, 0, 2)) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-stone-900">{{ '@' . $tweet->username }}</div>
                            <div class="text-xs text-stone-400">{{ \Carbon\Carbon::parse($tweet->created_at_twitter)->diffForHumans() }}</div>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide 
                        {{ $tweet->sentiment_label == 'Positif' ? 'bg-emerald-100 text-emerald-700' : 
                          ($tweet->sentiment_label == 'Negatif' ? 'bg-rose-100 text-rose-700' : 'bg-stone-100 text-stone-600') }}">
                        {{ $tweet->sentiment_label }}
                    </span>
                </div>
                
                {{-- Tweet Content --}}
                <p class="text-stone-700 text-sm leading-relaxed mb-4 tweet-text">
                    {!! preg_replace('/@(\w+)/', '<span class="text-blue-500 font-medium">@$1</span>', e($tweet->full_text)) !!}
                </p>

                {{-- Engagement Stats --}}
                <div class="flex items-center justify-between">
                    <div class="flex gap-4 text-xs text-stone-400 font-bold">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            {{ number_format($tweet->likes) }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            {{ number_format($tweet->retweets) }}
                        </span>
                    </div>
                    
                    @if($tweet->sentiment_score)
                    <span class="text-[10px] text-stone-400">
                        Score: {{ number_format($tweet->sentiment_score, 2) }}
                    </span>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 border-2 border-dashed border-stone-200 rounded-[24px]" id="emptyState">
                <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <p class="text-stone-500 font-bold">Belum ada data opini</p>
                <p class="text-xs text-stone-400 mt-2">Jalankan scraper untuk mengambil data dari X/Twitter</p>
            </div>
            @endforelse
        </div>

        {{-- No Results Message (Hidden by default) --}}
        <div id="noResults" class="hidden text-center py-12 border-2 border-dashed border-stone-200 rounded-[24px] mt-4">
            <p class="text-stone-400 font-bold">Tidak ada hasil yang cocok</p>
            <p class="text-xs text-stone-400 mt-1">Coba ubah filter atau kata kunci pencarian</p>
        </div>
    </div>
</div>

<script>
    // Chart
    const ctx = document.getElementById('chartDetail');
    if (ctx) {
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
            options: { 
                cutout: '80%', 
                plugins: { legend: { display: false } },
                animation: { animateRotate: true, animateScale: true }
            }
        });
    }

    // Filter, Sort & Search Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tweets = document.querySelectorAll('.tweet-card');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const showAllBtn = document.getElementById('showAllBtn');
        const sortSelect = document.getElementById('sortSelect');
        const searchInput = document.getElementById('searchInput');
        const visibleCountEl = document.getElementById('visibleCount');
        const noResults = document.getElementById('noResults');
        const container = document.getElementById('tweetsContainer');

        let currentFilter = 'all';
        let currentSearch = '';

        // Update visible count
        function updateVisibleCount() {
            let count = 0;
            tweets.forEach(tweet => {
                if (tweet.style.display !== 'none') count++;
            });
            visibleCountEl.textContent = count;
            
            // Show/hide no results message
            if (count === 0 && tweets.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Apply all filters
        function applyFilters() {
            tweets.forEach(tweet => {
                const sentiment = tweet.dataset.sentiment;
                const text = tweet.querySelector('.tweet-text').textContent.toLowerCase();
                
                const matchesFilter = currentFilter === 'all' || sentiment === currentFilter;
                const matchesSearch = currentSearch === '' || text.includes(currentSearch);

                if (matchesFilter && matchesSearch) {
                    tweet.style.display = 'block';
                } else {
                    tweet.style.display = 'none';
                }
            });
            
            updateVisibleCount();
        }

        // Filter by sentiment
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                currentFilter = this.dataset.filter;
                
                // Update button styles
                filterBtns.forEach(b => {
                    b.classList.remove('ring-2', 'ring-orange-500', 'bg-orange-50');
                    b.classList.add('bg-stone-50');
                });
                this.classList.add('ring-2', 'ring-orange-500', 'bg-orange-50');
                this.classList.remove('bg-stone-50');
                
                applyFilters();
            });
        });

        // Show all button
        showAllBtn.addEventListener('click', function() {
            currentFilter = 'all';
            currentSearch = '';
            searchInput.value = '';
            
            // Reset button styles
            filterBtns.forEach(b => {
                b.classList.remove('ring-2', 'ring-orange-500', 'bg-orange-50');
                b.classList.add('bg-stone-50');
            });
            
            // Show all tweets
            tweets.forEach(tweet => {
                tweet.style.display = 'block';
            });
            
            updateVisibleCount();
        });

        // Sort functionality
        sortSelect.addEventListener('change', function() {
            const sortBy = this.value;
            const tweetsArray = Array.from(tweets);
            
            tweetsArray.sort((a, b) => {
                switch(sortBy) {
                    case 'newest':
                        return parseInt(b.dataset.date) - parseInt(a.dataset.date);
                    case 'oldest':
                        return parseInt(a.dataset.date) - parseInt(b.dataset.date);
                    case 'likes':
                        return parseInt(b.dataset.likes) - parseInt(a.dataset.likes);
                    case 'retweets':
                        return parseInt(b.dataset.retweets) - parseInt(a.dataset.retweets);
                    default:
                        return 0;
                }
            });

            // Re-append sorted tweets
            tweetsArray.forEach(tweet => container.appendChild(tweet));
        });

        // Search functionality with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value.toLowerCase().trim();
                applyFilters();
            }, 300);
        });

        // Initial count
        updateVisibleCount();
    });
</script>
@endsection