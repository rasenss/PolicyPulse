@extends('layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-amber-50 to-stone-50">
    {{-- Header Section --}}
    <header class="pt-6 pb-8 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            {{-- Navigation --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-stone-700 hover:text-orange-600 transition-colors duration-300 group">
                    <div class="w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm border border-stone-200 flex items-center justify-center group-hover:bg-orange-50 group-hover:border-orange-200 transition-all duration-300">
                        <span class="text-lg group-hover:-translate-x-0.5 transition-transform">←</span>
                    </div>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>
                
                <div class="relative w-full md:w-96">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="search-material" placeholder="Telusuri materi kebijakan: pendidikan, ekonomi, kesehatan..." 
                               class="w-full pl-10 pr-4 py-3 bg-white/80 backdrop-blur-sm border border-white/50 rounded-2xl focus:outline-none focus:ring-3 focus:ring-orange-500/30 focus:border-transparent shadow-lg text-sm placeholder:text-stone-400">
                        <button id="clear-search" class="absolute inset-y-0 right-0 pr-3 flex items-center text-stone-400 hover:text-stone-600 hidden">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Hero Section --}}
            <div class="bg-gradient-to-br from-white/90 to-white/70 backdrop-blur-sm rounded-3xl p-6 md:p-10 shadow-xl border border-white/50 overflow-hidden relative">
                {{-- Decorative elements --}}
                <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-orange-100/50 to-amber-100/50 rounded-full -translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-gradient-to-br from-stone-100/50 to-stone-200/50 rounded-full translate-x-20 translate-y-20"></div>
                
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-8">
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center shadow-lg">
                                <span class="text-4xl">📚</span>
                            </div>
                        </div>
                        <div class="text-center md:text-left flex-1">
                            <h1 class="text-3xl md:text-4xl font-bold text-stone-900 mb-4">
                                <span class="bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent">
                                    Pembelajaran Kebijakan
                                </span>
                            </h1>
                            <p class="text-stone-600 text-lg max-w-3xl">
                                Dapatkan pengetahuan yang komprehensif mengenai kebijakan pemerintah Indonesia. 
                                Setiap konten dirancang untuk menawarkan wawasan segar dan sudut pandang yang unik.
                            </p>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 md:gap-8 max-w-2xl mx-auto">
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-orange-600 mb-1">9</div>
                            <div class="text-xs md:text-sm text-stone-500 font-medium">Area Kebijakan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-orange-600 mb-1">10+</div>
                            <div class="text-xs md:text-sm text-stone-500 font-medium">Materi Pembelajaran</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-orange-600 mb-1">24/7</div>
                            <div class="text-xs md:text-sm text-stone-500 font-medium">Ketersediaan Akses</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="pb-16 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            {{-- Search Results --}}
            <div id="search-results" class="hidden mb-8 animate-fadeIn">
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-xl border border-white/50">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-stone-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            Temuan Pencarian
                        </h2>
                        <button onclick="clearSearch()" class="text-sm text-stone-500 hover:text-stone-700 hover:bg-white/40 px-4 py-2 rounded-full transition">
                            ✕ Selesaikan Pencarian
                        </button>
                    </div>
                    <div id="results-container" class="space-y-4"></div>
                </div>
            </div>

            {{-- Category Selection --}}
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-stone-900 mb-6 text-center">
                    <span class="inline-flex items-center gap-2">
                        <span class="text-orange-500">🎯</span>
                        Jelajahi Bidang yang Anda Minati
                    </span>
                </h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    {{-- Pendidikan --}}
                    <button onclick="showSection('pendidikan')" class="category-card active group" data-category="pendidikan">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">🎓</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Pendidikan</h3>
                            <p class="text-xs text-stone-500">Evolusi sistem pembelajaran</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>

                    {{-- Ekonomi --}}
                    <button onclick="showSection('ekonomi')" class="category-card group" data-category="ekonomi">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">💰</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Ekonomi</h3>
                            <p class="text-xs text-stone-500">Pengembangan ekonomi merata</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>

                    {{-- Infrastruktur --}}
                    <button onclick="showSection('infrastruktur')" class="category-card group" data-category="infrastruktur">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">🏗️</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Infrastruktur</h3>
                            <p class="text-xs text-stone-500">Jaringan konektivitas nasional</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>

                    {{-- Kesehatan --}}
                    <button onclick="showSection('kesehatan')" class="category-card group" data-category="kesehatan">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">🏥</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Kesehatan</h3>
                            <p class="text-xs text-stone-500">Pelayanan kesehatan optimal</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>

                    {{-- Lingkungan --}}
                    <button onclick="showSection('lingkungan')" class="category-card group" data-category="lingkungan">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">🌿</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Lingkungan</h3>
                            <p class="text-xs text-stone-500">Kelestarian berkelanjutan</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>

                    {{-- Sosial --}}
                    <button onclick="showSection('sosial')" class="category-card group" data-category="sosial">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">👥</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Sosial</h3>
                            <p class="text-xs text-stone-500">Perlindungan masyarakat</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>

                    {{-- Hukum --}}
                    <button onclick="showSection('hukum')" class="category-card group" data-category="hukum">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">⚖️</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Hukum</h3>
                            <p class="text-xs text-stone-500">Penegakan keadilan</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>

                    {{-- Digital --}}
                    <button onclick="showSection('digital')" class="category-card group" data-category="digital">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">📱</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Digital</h3>
                            <p class="text-xs text-stone-500">Transformasi teknologi</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>

                    {{-- Energi --}}
                    <button onclick="showSection('energi')" class="category-card group" data-category="energi">
                        <div class="category-icon-wrapper">
                            <span class="text-3xl">⚡</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-stone-900 mb-1">Energi</h3>
                            <p class="text-xs text-stone-500">Energi berkelanjutan</p>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-orange-300 group-active:border-orange-500 rounded-2xl transition-all duration-300"></div>
                    </button>
                </div>
            </section>

            {{-- Content Sections --}}
            <div id="content-sections">
                {{-- SECTION 1: PENDIDIKAN --}}
                <div id="section-pendidikan" class="content-section">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">🎓</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Transformasi Pendidikan Indonesia</h2>
                                <p class="text-stone-600">Memahami pergeseran sistem pendidikan dari pendekatan konvensional menuju pembelajaran abad ke-21 yang berfokus pada kebutuhan peserta didik.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-blue">Pengetahuan Mendalam</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Evolusi Pendekatan Pembelajaran</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Peran guru berkembang menjadi fasilitator pembelajaran yang mendorong siswa untuk menemukan pengetahuan secara mandiri.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Pendekatan Konvensional
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Guru sebagai sumber utama pengetahuan</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Penekanan pada hafalan materi</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Evaluasi berdasarkan hasil akhir</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Metode pembelajaran seragam</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Pendekatan Modern
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-orange-500 mt-1">✓</span>
                                                    <span>Guru memandu proses pembelajaran</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-orange-500 mt-1">✓</span>
                                                    <span>Penekanan pada pemahaman konsep</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-orange-500 mt-1">✓</span>
                                                    <span>Evaluasi proses dan hasil belajar</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-orange-500 mt-1">✓</span>
                                                    <span>Pembelajaran berdiferensiasi</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Kompetensi Digital dalam Pendidikan</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Kemampuan digital mencakup keterampilan berpikir kritis dan bertanggung jawab di ruang digital.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">🔐</span>
                                            <span class="skill-name">Keamanan Digital</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🤔</span>
                                            <span class="skill-name">Berpikir Kritis</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">💬</span>
                                            <span class="skill-name">Etika Digital</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🎨</span>
                                            <span class="skill-name">Kreativitas Digital</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                        <p class="text-sm text-blue-800 flex items-start gap-2">
                                            <strong class="text-blue-900">📊 Data Penting:</strong>
                                            <span>Sebanyak 65% pekerjaan di masa depan membutuhkan kompetensi digital yang saat ini belum terintegrasi penuh dalam sistem pendidikan.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Memahami Pendidikan Inklusif</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Pendidikan inklusif memberikan kesempatan pembelajaran yang setara dengan dukungan yang sesuai kebutuhan setiap peserta didik.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">🌈</div>
                                            <h4 class="principle-title">Keberagaman sebagai Aset</h4>
                                            <p class="principle-desc">Perbedaan menjadi sumber pembelajaran bagi seluruh komunitas sekolah.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">⚙️</div>
                                            <h4 class="principle-title">Sistem yang Fleksibel</h4>
                                            <p class="principle-desc">Kurikulum dan metode pembelajaran menyesuaikan kebutuhan peserta didik.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🤝</div>
                                            <h4 class="principle-title">Kerja Sama Multipihak</h4>
                                            <p class="principle-desc">Kolaborasi antara guru, orang tua, dan profesional mendukung keberhasilan belajar.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Penerapan dalam Kehidupan Sehari-hari
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Orang Tua</h4>
                                        <ul class="action-list">
                                            <li>Ajukan pertanyaan tentang proses belajar anak daripada hanya menanyakan nilai</li>
                                            <li>Diskusikan informasi digital bersama keluarga untuk membangun berpikir kritis</li>
                                            <li>Dukung minat dan bakat unik yang dimiliki anak</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Pelajar dan Mahasiswa</h4>
                                        <ul class="action-list">
                                            <li>Jadilah pembelajar aktif dengan mencari sumber pengetahuan tambahan</li>
                                            <li>Kembangkan proyek yang menyelesaikan masalah di lingkungan sekitar</li>
                                            <li>Manfaatkan teknologi untuk menciptakan karya orisinal</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: EKONOMI --}}
                <div id="section-ekonomi" class="content-section hidden">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">💰</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Strategi Ekonomi Indonesia</h2>
                                <p class="text-stone-600">Memahami kebijakan ekonomi yang mendorong pertumbuhan berkelanjutan dan pemerataan kesejahteraan masyarakat.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-green">Aplikatif</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Digitalisasi Usaha Mikro Kecil Menengah</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Pemerintah mendukung transformasi digital 30 juta UMKM melalui platform e-commerce, pelatihan kompetensi digital, dan akses pembiayaan.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Hambatan UMKM
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Jangkauan pasar terbatas</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Akses modal terbatas</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Kompetensi digital dasar</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Manajemen usaha tradisional</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Solusi Digital
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-green-500 mt-1">✓</span>
                                                    <span>Platform e-commerce nasional</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-green-500 mt-1">✓</span>
                                                    <span>Layanan fintech untuk pinjaman</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-green-500 mt-1">✓</span>
                                                    <span>Program pelatihan digital</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-green-500 mt-1">✓</span>
                                                    <span>Sistem manajemen digital</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Pengembangan Kawasan Ekonomi Khusus</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Pengembangan 15 Kawasan Ekonomi Khusus strategis menarik investasi dan menciptakan pusat pertumbuhan ekonomi baru.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">🏭</span>
                                            <span class="skill-name">Kawasan Industri</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🛳️</span>
                                            <span class="skill-name">Pelabuhan Internasional</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">📊</span>
                                            <span class="skill-name">Pusat Logistik</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🏨</span>
                                            <span class="skill-name">Pariwisata Premium</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                                        <p class="text-sm text-green-800 flex items-start gap-2">
                                            <strong class="text-green-900">📈 Data Ekonomi:</strong>
                                            <span>Kawasan Ekonomi Khusus telah menyerap 500.000 tenaga kerja dan menarik investasi senilai Rp 150 triliun sejak 2014.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Koordinasi Kebijakan Moneter dan Fiskal</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Koordinasi antara Bank Indonesia dan Kementerian Keuangan menciptakan stabilitas makroekonomi yang mendukung pertumbuhan inklusif.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">📈</div>
                                            <h4 class="principle-title">Stabilitas Harga</h4>
                                            <p class="principle-desc">Kebijakan suku bunga mengendalikan inflasi dan menjaga daya beli masyarakat.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">💱</div>
                                            <h4 class="principle-title">Stabilitas Nilai Tukar</h4>
                                            <p class="principle-desc">Intervensi devisa menjaga stabilitas nilai tukar Rupiah terhadap mata uang asing.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🏦</div>
                                            <h4 class="principle-title">Sistem Perbankan Sehat</h4>
                                            <p class="principle-desc">Pengawasan memastikan fungsi intermediasi perbankan berjalan optimal.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Peluang dan Strategi untuk Masyarakat
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Pengusaha UMKM</h4>
                                        <ul class="action-list">
                                            <li>Manfaatkan program digitalisasi dari Kementerian Koperasi dan UKM</li>
                                            <li>Gunakan platform fintech untuk akses pembiayaan usaha</li>
                                            <li>Ikuti pelatihan kompetensi melalui Kartu Prakerja</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Investor dan Pelaku Bisnis</h4>
                                        <ul class="action-list">
                                            <li>Eksplorasi peluang di Kawasan Ekonomi Khusus dengan insentif pajak</li>
                                            <li>Manfaatkan skema peer-to-peer lending sebagai alternatif investasi</li>
                                            <li>Perhatikan regulasi ekonomi hijau sebagai tren investasi masa depan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: INFRASTRUKTUR --}}
                <div id="section-infrastruktur" class="content-section hidden">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">🏗️</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Pembangunan Infrastruktur Nasional</h2>
                                <p class="text-stone-600">Memahami strategi pembangunan infrastruktur sebagai fondasi pertumbuhan ekonomi dan konektivitas nasional.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-gray">Transformasi Fisik</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Konektivitas Maritim melalui Tol Laut</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Sistem logistik maritim menghubungkan 17.000 pulau Indonesia untuk pemerataan pembangunan dan pertumbuhan ekonomi.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Sebelum Program Tol Laut
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Biaya logistik mencapai 30-40% dari harga barang</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Frekuensi pelayaran tidak teratur</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Infrastruktur pelabuhan terbatas</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Harga barang bervariasi antar wilayah</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Setelah Program Tol Laut
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-blue-500 mt-1">✓</span>
                                                    <span>Biaya logistik turun 25-35%</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-blue-500 mt-1">✓</span>
                                                    <span>Jadwal pelayaran tetap dan terjamin</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-blue-500 mt-1">✓</span>
                                                    <span>24 pelabuhan hub nasional beroperasi</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-blue-500 mt-1">✓</span>
                                                    <span>Harga barang lebih stabil di seluruh Indonesia</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Jaringan Jalan Tol Trans-Sumatra dan Trans-Jawa</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Jaringan jalan tol sepanjang 2.818 kilometer menghubungkan pusat produksi dengan pusat konsumsi di seluruh Indonesia.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">🚚</span>
                                            <span class="skill-name">Efisiensi Logistik</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">⏱️</span>
                                            <span class="skill-name">Pengurangan Waktu</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">💰</span>
                                            <span class="skill-name">Penghematan Biaya</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🏭</span>
                                            <span class="skill-name">Akses Industri</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                        <p class="text-sm text-blue-800 flex items-start gap-2">
                                            <strong class="text-blue-900">🚀 Dampak Ekonomi:</strong>
                                            <span>Pengurangan waktu tempuh Jakarta-Surabaya dari 14 jam menjadi 8 jam meningkatkan produktivitas ekonomi regional hingga 40%.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Infrastruktur Digital dan Telekomunikasi</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Palapa Ring sebagai tulang punggung digital nasional menghubungkan seluruh wilayah Indonesia dengan jaringan internet berkecepatan tinggi.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">🌐</div>
                                            <h4 class="principle-title">Jaringan Backbone Nasional</h4>
                                            <p class="principle-desc">Kabel fiber optik bawah laut sepanjang 13.000 kilometer menghubungkan seluruh provinsi.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">📡</div>
                                            <h4 class="principle-title">Satelit Republik Indonesia</h4>
                                            <p class="principle-desc">Satelit multifungsi mendukung telekomunikasi dan komunikasi darurat di daerah terpencil.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🏙️</div>
                                            <h4 class="principle-title">Infrastruktur Kota Cerdas</h4>
                                            <p class="principle-desc">Pengembangan 100 kota cerdas dengan integrasi Internet of Things untuk pengelolaan kota yang efisien.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Dampak dan Peluang untuk Masyarakat
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Pelaku Usaha dan Logistik</h4>
                                        <ul class="action-list">
                                            <li>Manfaatkan koridor ekonomi baru yang terbuka melalui akses jalan tol</li>
                                            <li>Optimalkan rantai pasok dengan waktu tempuh yang lebih singkat</li>
                                            <li>Ekspansi pasar ke daerah tertinggal, terdepan, dan terluar yang sebelumnya sulit dijangkau</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Masyarakat Umum</h4>
                                        <ul class="action-list">
                                            <li>Akses layanan publik yang lebih baik melalui konektivitas digital</li>
                                            <li>Kesempatan kerja baru di sektor konstruksi dan pemeliharaan infrastruktur</li>
                                            <li>Mobilitas yang lebih mudah untuk pendidikan, kesehatan, dan pariwisata</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: KESEHATAN --}}
                <div id="section-kesehatan" class="content-section hidden">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">🏥</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Transformasi Sistem Kesehatan Nasional</h2>
                                <p class="text-stone-600">Memahami reformasi sistem kesehatan menuju cakupan kesehatan semesta dan pelayanan kesehatan berkualitas untuk seluruh masyarakat.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-red">Kesehatan Holistik</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Jaminan Kesehatan Nasional</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Sistem asuransi kesehatan sosial terbesar di dunia dengan lebih dari 230 juta peserta menjamin akses pelayanan kesehatan dasar.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Sebelum JKN
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Fasilitas kesehatan terfragmentasi</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Biaya kesehatan ditanggung mandiri</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Akses layanan tidak merata</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Kualitas pelayanan bervariasi</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Setelah JKN
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-500 mt-1">✓</span>
                                                    <span>Sistem kesehatan terintegrasi nasional</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-500 mt-1">✓</span>
                                                    <span>Biaya kesehatan ditanggung BPJS</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-500 mt-1">✓</span>
                                                    <span>Akses universal mencakup 85% populasi</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-500 mt-1">✓</span>
                                                    <span>Standar pelayanan kesehatan nasional</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Penguatan Layanan Kesehatan Primer</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Penguatan 10.000 Puskesmas dan 300.000 Posyandu sebagai garda terdepan sistem kesehatan melalui transformasi digital dan peningkatan kapasitas.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">👨‍⚕️</span>
                                            <span class="skill-name">Tenaga Kesehatan</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">💊</span>
                                            <span class="skill-name">Obat Esensial</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🩺</span>
                                            <span class="skill-name">Alat Kesehatan</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">📱</span>
                                            <span class="skill-name">Telemedisin</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                                        <p class="text-sm text-red-800 flex items-start gap-2">
                                            <strong class="text-red-900">🏥 Transformasi Digital:</strong>
                                            <span>Aplikasi Sehat Indonesiaku menghubungkan 10.000 Puskesmas dengan sistem informasi terintegrasi untuk pelayanan yang lebih efisien.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Kemandirian Farmasi dan Alat Kesehatan</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Strategi mengurangi ketergantungan impor dengan mengembangkan industri farmasi dan alat kesehatan dalam negeri.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">🏭</div>
                                            <h4 class="principle-title">Industri Farmasi Nasional</h4>
                                            <p class="principle-desc">Peningkatan kapasitas produksi obat generik dan vaksin untuk kemandirian kesehatan.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🔬</div>
                                            <h4 class="principle-title">Riset dan Inovasi</h4>
                                            <p class="principle-desc">Pengembangan obat baru dan alat kesehatan hasil penelitian dalam negeri.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🌿</div>
                                            <h4 class="principle-title">Obat Herbal Terstandar</h4>
                                            <p class="principle-desc">Penelitian dan pengembangan obat tradisional Indonesia yang teruji klinis.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Strategi Hidup Sehat di Era Modern
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Masyarakat Umum</h4>
                                        <ul class="action-list">
                                            <li>Manfaatkan pemeriksaan kesehatan berkala di Puskesmas terdekat</li>
                                            <li>Unduh aplikasi Sehat Indonesiaku untuk akses informasi kesehatan terpercaya</li>
                                            <li>Ikuti program Gerakan Masyarakat Hidup Sehat untuk pencegahan penyakit</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Tenaga Kesehatan</h4>
                                        <ul class="action-list">
                                            <li>Manfaatkan program Nusantara Sehat untuk penempatan di daerah terpencil</li>
                                            <li>Ikuti pelatihan telemedisin untuk perluasan jangkauan layanan</li>
                                            <li>Gunakan sistem informasi terpadu untuk pencatatan dan pelaporan yang efektif</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 5: LINGKUNGAN --}}
                <div id="section-lingkungan" class="content-section hidden">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">🌿</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Kebijakan Lingkungan Berkelanjutan</h2>
                                <p class="text-stone-600">Memahami strategi pembangunan berkelanjutan yang mengintegrasikan pertumbuhan ekonomi dengan pelestarian lingkungan.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-emerald">Berkelanjutan</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Target Nol Emisi Bersih 2060</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Komitmen Indonesia mencapai emisi nol bersih pada tahun 2060 dengan peta jalan transisi energi dan ekonomi hijau.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Pola Pembangunan Konvensional
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Ekstraktif dan eksploitatif</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Tinggi emisi karbon</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Kerusakan ekosistem</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Ketergantungan sumber daya terbatas</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Pola Pembangunan Berkelanjutan
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-emerald-500 mt-1">✓</span>
                                                    <span>Sirkular dan regeneratif</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-emerald-500 mt-1">✓</span>
                                                    <span>Rendah emisi karbon</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-emerald-500 mt-1">✓</span>
                                                    <span>Restorasi ekosistem</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-emerald-500 mt-1">✓</span>
                                                    <span>Pemanfaatan sumber daya terbarukan</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Pengelolaan Sampah dan Ekonomi Sirkular</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Transformasi pengelolaan 64 juta ton sampah per tahun dari model linear menuju model sirkular yang bernilai ekonomi.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">♻️</span>
                                            <span class="skill-name">Pengurangan dan Penggunaan Ulang</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🏭</span>
                                            <span class="skill-name">Daur Ulang</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">⚡</span>
                                            <span class="skill-name">Konversi Sampah menjadi Energi</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">📊</span>
                                            <span class="skill-name">Tanggung Jawab Produsen</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-200">
                                        <p class="text-sm text-emerald-800 flex items-start gap-2">
                                            <strong class="text-emerald-900">🌍 Target Nasional:</strong>
                                            <span>Pengurangan sampah 30% dan penanganan sampah 70% melalui pengelolaan terpadu pada 2025, menciptakan ekonomi sirkular senilai Rp 50 triliun.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Kebijakan Pengelolaan Hutan dan Lahan Gambut</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Strategi moratorium dan restorasi 66 juta hektar untuk mengembalikan fungsi ekologis hutan dan lahan gambut.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">🌳</div>
                                            <h4 class="principle-title">Moratorium Hutan Primer</h4>
                                            <p class="principle-desc">Penghentian pemberian izin baru untuk hutan primer dan lahan gambut.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🔥</div>
                                            <h4 class="principle-title">Pengendalian Kebakaran Hutan</h4>
                                            <p class="principle-desc">Sistem deteksi dini dan pemadaman terintegrasi untuk mencegah kebakaran hutan dan lahan.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">💧</div>
                                            <h4 class="principle-title">Restorasi Lahan Gambut</h4>
                                            <p class="principle-desc">Restorasi 2,4 juta hektar lahan gambut untuk mengurangi risiko kebakaran.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Peran Aktif Masyarakat dalam Pelestarian
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Rumah Tangga dan Komunitas</h4>
                                        <ul class="action-list">
                                            <li>Terapkan pemilahan sampah dari sumber untuk memudahkan daur ulang</li>
                                            <li>Ikuti program bank sampah untuk mengubah sampah menjadi nilai ekonomi</li>
                                            <li>Tanam pohon di lingkungan melalui program satu orang satu pohon</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Pelaku Usaha dan Industri</h4>
                                        <ul class="action-list">
                                            <li>Terapkan produksi bersih untuk mengurangi limbah dan emisi</li>
                                            <li>Implementasikan tanggung jawab sosial perusahaan untuk restorasi ekosistem</li>
                                            <li>Gunakan energi terbarukan dalam proses produksi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 6: SOSIAL --}}
                <div id="section-sosial" class="content-section hidden">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">👥</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Kebijakan Sosial Inklusif</h2>
                                <p class="text-stone-600">Memahami sistem perlindungan sosial yang melindungi kelompok rentan dan meningkatkan kesejahteraan masyarakat.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-purple">Inklusif</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Program Keluarga Harapan</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Bantuan bersyarat untuk 10 juta keluarga sangat miskin dengan mekanisme yang memberdayakan dan memutus mata rantai kemiskinan.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Bantuan Langsung Tunai
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Bantuan tanpa persyaratan</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Tidak mendorong perubahan perilaku</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Berpotensi menciptakan ketergantungan</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Dampak terbatas pada jangka pendek</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Bantuan Bersyarat (PKH)
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-purple-500 mt-1">✓</span>
                                                    <span>Persyaratan pendidikan dan kesehatan</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-purple-500 mt-1">✓</span>
                                                    <span>Mendorong perubahan perilaku positif</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-purple-500 mt-1">✓</span>
                                                    <span>Pemberdayaan berkelanjutan</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-purple-500 mt-1">✓</span>
                                                    <span>Pemutusan siklus kemiskinan antar generasi</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Kartu Indonesia Pintar dan Kartu Indonesia Sehat</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Akses pendidikan dan kesehatan untuk seluruh warga melalui sistem identifikasi terpadu yang menjamin hak dasar.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">🎓</span>
                                            <span class="skill-name">Pendidikan Inklusif</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🏥</span>
                                            <span class="skill-name">Kesehatan Universal</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">📊</span>
                                            <span class="skill-name">Data Terpadu</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🔍</span>
                                            <span class="skill-name">Penyaluran Tepat Sasaran</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                                        <p class="text-sm text-purple-800 flex items-start gap-2">
                                            <strong class="text-purple-900">👨‍👩‍👧‍👦 Jangkauan Luas:</strong>
                                            <span>20,3 juta siswa penerima KIP dan 96,8 juta penerima KIS menjamin akses dasar bagi seluruh warga Indonesia.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Pemberdayaan Kelompok Rentan dan Penyandang Disabilitas</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Kebijakan afirmatif untuk kesetaraan 21 juta penyandang disabilitas dan pemenuhan hak-hak dasar kelompok rentan.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">♿</div>
                                            <h4 class="principle-title">Aksesibilitas Universal</h4>
                                            <p class="principle-desc">Standar aksesibilitas fasilitas publik untuk penyandang disabilitas di seluruh Indonesia.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">👵</div>
                                            <h4 class="principle-title">Perlindungan Lansia</h4>
                                            <p class="principle-desc">Program jaminan sosial dan layanan kesehatan khusus untuk 28 juta lansia.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">👶</div>
                                            <h4 class="principle-title">Perlindungan Anak</h4>
                                            <p class="principle-desc">Sistem pencegahan dan penanganan kekerasan terhadap 80 juta anak Indonesia.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Sinergi Masyarakat dalam Perlindungan Sosial
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Masyarakat Umum</h4>
                                        <ul class="action-list">
                                            <li>Dukung program inklusi sosial dengan menghilangkan stigma terhadap kelompok rentan</li>
                                            <li>Laporkan kasus kekerasan melalui sistem pelaporan terpadu 112</li>
                                            <li>Berpartisipasi dalam gotong royong untuk membantu tetangga yang membutuhkan</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Organisasi Kemasyarakatan</h4>
                                        <ul class="action-list">
                                            <li>Kolaborasi dengan pemerintah dalam penyaluran bantuan sosial yang tepat sasaran</li>
                                            <li>Lakukan pendampingan bagi penerima bantuan untuk pemberdayaan berkelanjutan</li>
                                            <li>Advokasi kebijakan sosial yang responsif terhadap kebutuhan masyarakat</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 7: HUKUM --}}
                <div id="section-hukum" class="content-section hidden">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">⚖️</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Reformasi Hukum dan Birokrasi</h2>
                                <p class="text-stone-600">Memahami transformasi sistem hukum menuju penegakan hukum yang adil dan birokrasi yang efisien.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-slate">Keadilan</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Undang-Undang Omnibus dan Penyederhanaan Regulasi</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Penataan ulang 79 Undang-Undang dan 1.200 peraturan untuk menciptakan iklim investasi yang kondusif dengan kepastian hukum.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Sistem Regulasi Sebelumnya
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Regulasi berlebihan dan tumpang tindih</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Proses birokrasi berbelit-belit</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Ketidakpastian hukum</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Hambatan investasi</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Sistem Regulasi Baru
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-slate-500 mt-1">✓</span>
                                                    <span>Regulasi terintegrasi</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-slate-500 mt-1">✓</span>
                                                    <span>Birokrasi efisien secara online</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-slate-500 mt-1">✓</span>
                                                    <span>Kepastian hukum</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-slate-500 mt-1">✓</span>
                                                    <span>Kemudahan berusaha</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Sistem Peradilan Terpadu dan Pengadilan Elektronik</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Digitalisasi 800 pengadilan di Indonesia untuk transparansi dan efisiensi proses hukum melalui sistem online terintegrasi.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">⚖️</span>
                                            <span class="skill-name">Pengadilan Online</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">📄</span>
                                            <span class="skill-name">Dokumen Elektronik</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🔄</span>
                                            <span class="skill-name">Proses Digital</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">📊</span>
                                            <span class="skill-name">Transparansi Publik</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                        <p class="text-sm text-slate-800 flex items-start gap-2">
                                            <strong class="text-slate-900">⚡ Inovasi Sistem:</strong>
                                            <span>Sistem Pengadilan Elektronik telah mengurangi waktu proses peradilan dari rata-rata 300 hari menjadi 180 hari dan meningkatkan transparansi keputusan hukum.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Pemberantasan Korupsi dan Reformasi Birokrasi</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Strategi sistemik untuk mewujudkan pemerintahan bersih melalui koordinasi Komisi Pemberantasan Korupsi, Badan Pemeriksa Keuangan, dan sistem pengawasan terintegrasi.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">🔍</div>
                                            <h4 class="principle-title">Pengawasan Terintegrasi</h4>
                                            <p class="principle-desc">Koordinasi KPK, BPK, dan Inspektorat dalam pencegahan dan penindakan korupsi.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">💰</div>
                                            <h4 class="principle-title">Transparansi Anggaran</h4>
                                            <p class="principle-desc">Sistem informasi keuangan daerah untuk mencegah penyimpangan anggaran publik.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">📱</div>
                                            <h4 class="principle-title">Pemerintahan Elektronik</h4>
                                            <p class="principle-desc">Digitalisasi 4.000 layanan publik untuk mengurangi interaksi langsung dan potensi suap.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Masyarakat sebagai Kontrol Sosial
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Warga Negara</h4>
                                        <ul class="action-list">
                                            <li>Gunakan hak informasi publik untuk mengawasi kinerja pemerintah dan lembaga negara</li>
                                            <li>Laporkan dugaan korupsi melalui kanal pelaporan KPK dan Ombudsman</li>
                                            <li>Berpartisipasi dalam musyawarah perencanaan pembangunan untuk mengawal penggunaan anggaran publik</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Pelaku Usaha</h4>
                                        <ul class="action-list">
                                            <li>Patuhi prinsip kepatuhan dalam seluruh aktivitas bisnis dan korporasi</li>
                                            <li>Manfaatkan sistem perizinan online untuk menghindari pungutan liar dan mempercepat proses</li>
                                            <li>Implementasikan tata kelola perusahaan yang baik dalam perusahaan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 8: DIGITAL --}}
                <div id="section-digital" class="content-section hidden">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-100 to-cyan-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">📱</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Transformasi Digital Nasional</h2>
                                <p class="text-stone-600">Memahami strategi percepatan transformasi digital untuk menciptakan ekonomi digital inklusif dan masyarakat informasi yang maju.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-cyan">Digitalisasi</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Infrastruktur Digital Nasional</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Pengembangan tulang punggung digital nasional 13.000 kilometer untuk konektivitas internet merata ke 83.000 desa di seluruh Indonesia.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Kondisi Digitalisasi Awal
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Kesenjangan digital antara kota dan desa</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Infrastruktur terpusat di Pulau Jawa</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Kecepatan internet rendah</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Biaya akses tinggi</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-cyan-50 rounded-xl p-4 border border-cyan-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Target Digital Nasional
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-cyan-500 mt-1">✓</span>
                                                    <span>Internet merata ke seluruh desa</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-cyan-500 mt-1">✓</span>
                                                    <span>Infrastruktur tersebar merata</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-cyan-500 mt-1">✓</span>
                                                    <span>Kecepatan minimal 10 Mbps</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-cyan-500 mt-1">✓</span>
                                                    <span>Biaya terjangkau untuk semua</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Pengembangan Talenta Digital Indonesia</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Pengembangan 9 juta talenta digital berkualitas untuk memenangkan persaingan ekonomi digital global.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">👨‍💻</span>
                                            <span class="skill-name">Pemrogram</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">📊</span>
                                            <span class="skill-name">Ilmuwan Data</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🔒</span>
                                            <span class="skill-name">Keamanan Siber</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🤖</span>
                                            <span class="skill-name">Insinyur Kecerdasan Buatan</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-cyan-50 rounded-xl p-4 border border-cyan-200">
                                        <p class="text-sm text-cyan-800 flex items-start gap-2">
                                            <strong class="text-cyan-900">🎯 Target Nasional:</strong>
                                            <span>9 juta talenta digital terampil pada 2030 melalui program Kartu Prakerja dan Beasiswa Talenta Digital dengan investasi Rp 5 triliun.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Ekonomi Digital dan Startup Nasional</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Menciptakan ekosistem digital yang produktif dengan 10 perusahaan unicorn dan 1 decacorn Indonesia yang berdaya saing global.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">🚀</div>
                                            <h4 class="principle-title">Startup Indonesia</h4>
                                            <p class="principle-desc">Dukungan inkubasi dan pendanaan untuk 1.000 startup technopreneur Indonesia.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🏦</div>
                                            <h4 class="principle-title">Fintech Inklusif</h4>
                                            <p class="principle-desc">Pengembangan 300 perusahaan fintech untuk perluasan akses keuangan bagi 60 juta UMKM.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🛒</div>
                                            <h4 class="principle-title">E-Commerce Nasional</h4>
                                            <p class="principle-desc">Platform digital untuk pemasaran 30 juta produk UMKM ke pasar domestik dan global.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Adaptasi Masyarakat di Era Digital
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Masyarakat Umum</h4>
                                        <ul class="action-list">
                                            <li>Manfaatkan pelatihan digital gratis dari program pemerintah untuk peningkatan keterampilan</li>
                                            <li>Gunakan aplikasi pelayanan publik seperti INA Digital untuk efisiensi waktu dan biaya</li>
                                            <li>Tingkatkan literasi digital untuk melindungi diri dari hoaks dan kejahatan siber</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Pelaku UMKM dan Startup</h4>
                                        <ul class="action-list">
                                            <li>Manfaatkan platform e-commerce pemerintah untuk perluasan pasar nasional dan global</li>
                                            <li>Ikuti program akselerasi startup dari Kementerian Koperasi dan UKM serta Kementerian Komunikasi dan Informatika</li>
                                            <li>Gunakan teknologi cloud untuk efisiensi operasional dan skalabilitas bisnis</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 9: ENERGI --}}
                <div id="section-energi" class="content-section hidden">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border border-white/50 mb-8">
                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-100 to-yellow-200 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">⚡</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-stone-900 mb-2">Transisi Energi Berkelanjutan</h2>
                                <p class="text-stone-600">Memahami strategi transisi energi dari bahan bakar fosil menuju energi terbarukan untuk masa depan yang berkelanjutan.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="tag tag-yellow">Transisi Energi</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-6">
                            {{-- Insight 1 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">01</span>
                                    <h3 class="insight-title">Energi Baru Terbarukan</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Pengembangan sumber energi bersih 32 gigawatt kapasitas untuk mengurangi ketergantungan 60% pada bahan bakar fosil.</p>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="bg-stone-50 rounded-xl p-4 border border-stone-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-red-500">●</span>
                                                Bauran Energi 2020
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Batu bara: 38%</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Minyak: 31%</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Gas: 19%</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-stone-400 mt-1">•</span>
                                                    <span>Energi terbarukan: 12%</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                                            <div class="font-semibold text-stone-900 mb-2 flex items-center gap-2">
                                                <span class="text-green-500">●</span>
                                                Target Bauran 2025
                                            </div>
                                            <ul class="space-y-2 text-sm text-stone-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-yellow-500 mt-1">✓</span>
                                                    <span>Batu bara: 30%</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-yellow-500 mt-1">✓</span>
                                                    <span>Minyak: 25%</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-yellow-500 mt-1">✓</span>
                                                    <span>Gas: 22%</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-yellow-500 mt-1">✓</span>
                                                    <span>Energi terbarukan: 23%</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Insight 2 --}}
                            <div class="insight-card">
                                <div class="insight-header">
                                    <span class="insight-number">02</span>
                                    <h3 class="insight-title">Kendaraan Listrik dan Transportasi Bersih</h3>
                                </div>
                                <div class="insight-content">
                                    <p class="mb-4">Transformasi sistem transportasi 15 juta unit menuju ramah lingkungan dan efisien energi dengan insentif komprehensif.</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="skill-item">
                                            <span class="skill-icon">🚗</span>
                                            <span class="skill-name">Mobil Listrik</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🛵</span>
                                            <span class="skill-name">Motor Listrik</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🔋</span>
                                            <span class="skill-name">Stasiun Pengisian</span>
                                        </div>
                                        <div class="skill-item">
                                            <span class="skill-icon">🚌</span>
                                            <span class="skill-name">Transportasi Umum Listrik</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                                        <p class="text-sm text-yellow-800 flex items-start gap-2">
                                            <strong class="text-yellow-900">🚀 Target Nasional:</strong>
                                            <span>2 juta mobil listrik dan 13 juta motor listrik pada 2030 dengan 31.859 stasiun pengisian dan insentif pajak hingga 100%.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Deep Dive --}}
                            <div class="deep-dive">
                                <div class="deep-dive-header">
                                    <span class="text-2xl">🔍</span>
                                    <h3 class="deep-dive-title">Energi Terbarukan Berbasis Potensi Lokal</h3>
                                </div>
                                <div class="deep-dive-content">
                                    <p class="mb-6">Pemanfaatan sumber energi terbarukan 417 gigawatt potensi sesuai karakteristik daerah di Indonesia untuk kemandirian energi.</p>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="principle-card">
                                            <div class="principle-icon">☀️</div>
                                            <h4 class="principle-title">Energi Surya</h4>
                                            <p class="principle-desc">Pembangkit listrik tenaga surya dengan potensi 207 gigawatt di seluruh Indonesia.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">💨</div>
                                            <h4 class="principle-title">Energi Angin</h4>
                                            <p class="principle-desc">Energi angin di wilayah pesisir dengan potensi 60 gigawatt terutama di Nusa Tenggara Timur dan Sulawesi.</p>
                                        </div>
                                        <div class="principle-card">
                                            <div class="principle-icon">🌋</div>
                                            <h4 class="principle-title">Energi Panas Bumi</h4>
                                            <p class="principle-desc">Panas bumi sebagai sumber energi bersih dengan potensi 29 gigawatt terbesar di dunia.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actionable Insights --}}
                            <div class="actionable-insights">
                                <h3 class="text-xl font-bold text-stone-900 mb-4 flex items-center gap-2">
                                    <span class="text-orange-500">🎯</span>
                                    Kontribusi Masyarakat dalam Transisi Energi
                                </h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Rumah Tangga dan Komunitas</h4>
                                        <ul class="action-list">
                                            <li>Pasang panel surya atap dengan insentif pemerintah untuk memanfaatkan energi matahari</li>
                                            <li>Ganti peralatan listrik dengan yang berlabel hemat energi untuk efisiensi 30-50%</li>
                                            <li>Ikuti program konversi ke kompor listrik atau gas untuk mengurangi emisi</li>
                                        </ul>
                                    </div>
                                    <div class="action-card">
                                        <h4 class="action-title">Untuk Pelaku Usaha dan Industri</h4>
                                        <ul class="action-list">
                                            <li>Implementasikan audit energi untuk identifikasi peluang efisiensi penggunaan energi</li>
                                            <li>Investasi pada energi terbarukan seperti pembangkit listrik tenaga surya atap untuk operasional perusahaan</li>
                                            <li>Konversi armada transportasi ke kendaraan listrik dengan insentif pajak</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Call to Action --}}
            <div class="text-center mt-12">
                <div class="flex flex-wrap gap-4 justify-center">
                    <button onclick="exploreRandomTopic()" class="cta-button">
                        <span class="flex items-center gap-2">
                            <span>🎲</span>
                            Temukan Topik Acak
                        </span>
                    </button>
                    <button onclick="scrollToTop()" class="cta-button-secondary">
                        <span class="flex items-center gap-2">
                            <span>⬆️</span>
                            Ke Bagian Atas
                        </span>
                    </button>
                </div>
                <p class="text-stone-500 text-sm mt-4">Setiap topik menghadirkan perspektif baru tentang Indonesia</p>
            </div>
        </div>
    </main>
</div>

<style>
/* Custom Styles */
.category-card {
    background: white;
    border-radius: 1.25rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    border: 1px solid #f3f4f6;
    height: 100%;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(249, 115, 22, 0.15);
}

.category-card.active {
    background: linear-gradient(135deg, #fffbeb 0%, #fff7ed 100%);
    border-color: #fdba74;
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.1);
}

.category-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 1rem;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.category-card.active .category-icon-wrapper {
    background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
}

/* Tags */
.tag {
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-block;
}

.tag-blue {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.tag-green {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
}

.tag-red {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.tag-gray {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #475569;
}

.tag-emerald {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.tag-purple {
    background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
    color: #7c3aed;
}

.tag-slate {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #334155;
}

.tag-cyan {
    background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
    color: #155e75;
}

.tag-yellow {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

/* Insight Cards */
.insight-card {
    background: white;
    border-radius: 1.25rem;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    margin-bottom: 1rem;
}

.insight-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.insight-number {
    background: #f97316;
    color: white;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.insight-title {
    font-weight: 600;
    color: #1f2937;
    font-size: 1.125rem;
}

.insight-content {
    color: #4b5563;
}

/* Skill Items */
.skill-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    text-align: center;
}

.skill-icon {
    font-size: 1.5rem;
}

.skill-name {
    font-size: 0.75rem;
    font-weight: 500;
    color: #475569;
}

/* Deep Dive */
.deep-dive {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-radius: 1.25rem;
    padding: 1.5rem;
    border: 1px solid #bae6fd;
    margin: 1.5rem 0;
}

.deep-dive-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.deep-dive-title {
    font-weight: 600;
    color: #1f2937;
    font-size: 1.125rem;
}

.principle-card {
    background: white;
    padding: 1.25rem;
    border-radius: 1rem;
    text-align: center;
    border: 1px solid #e2e8f0;
}

.principle-icon {
    font-size: 2rem;
    margin-bottom: 0.75rem;
    display: block;
}

.principle-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.principle-desc {
    font-size: 0.75rem;
    color: #6b7280;
    line-height: 1.4;
}

/* Actionable Insights */
.actionable-insights {
    background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
    border-radius: 1.25rem;
    padding: 1.5rem;
    border: 1px solid #fde047;
    margin-top: 1.5rem;
}

.action-card {
    background: white;
    padding: 1.25rem;
    border-radius: 1rem;
    border: 1px solid #e5e7eb;
}

.action-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f97316;
    font-size: 1rem;
}

.action-list {
    list-style: none;
    padding: 0;
    margin: 0;
    color: #4b5563;
}

.action-list li {
    padding: 0.375rem 0;
    position: relative;
    padding-left: 1.25rem;
    font-size: 0.875rem;
}

.action-list li:before {
    content: "→";
    position: absolute;
    left: 0;
    color: #f97316;
    font-weight: 600;
}

/* CTA Buttons */
.cta-button {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    font-weight: 600;
    padding: 0.875rem 1.75rem;
    border-radius: 9999px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.2);
    font-size: 0.875rem;
}

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3);
}

.cta-button-secondary {
    background: white;
    color: #57534e;
    font-weight: 600;
    padding: 0.875rem 1.75rem;
    border-radius: 9999px;
    border: 2px solid #e5e7eb;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.cta-button-secondary:hover {
    background: #fafaf9;
    border-color: #d6d3d1;
    transform: translateY(-2px);
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

.content-section {
    animation: fadeIn 0.3s ease-in;
}

/* Responsive */
@media (max-width: 768px) {
    .category-card {
        min-height: 120px;
        padding: 1rem;
    }
    
    .category-icon-wrapper {
        width: 48px;
        height: 48px;
    }
    
    .insight-card,
    .deep-dive,
    .actionable-insights {
        padding: 1rem;
    }
    
    .grid-cols-2,
    .grid-cols-3,
    .grid-cols-4 {
        gap: 0.5rem;
    }
}

@media (max-width: 640px) {
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .skill-item {
        padding: 0.5rem;
    }
    
    .cta-button,
    .cta-button-secondary {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Search Data
const searchData = [
    {
        id: 'pendidikan-paradigma',
        title: 'Evolusi Pendekatan Pembelajaran',
        content: 'Peran guru berkembang menjadi fasilitator pembelajaran dengan fokus pada pemahaman konsep dan pembelajaran berdiferensiasi.',
        section: 'pendidikan',
        keywords: ['paradigma', 'pembelajaran', 'guru', 'siswa', 'metode', 'pendidikan']
    },
    {
        id: 'pendidikan-digital',
        title: 'Kompetensi Digital dalam Pendidikan',
        content: 'Kemampuan digital mencakup keterampilan berpikir kritis dan bertanggung jawab di ruang digital.',
        section: 'pendidikan',
        keywords: ['digital', 'literasi', 'teknologi', 'keamanan', 'etika', 'kritis']
    },
    {
        id: 'ekonomi-umkm',
        title: 'Digitalisasi Usaha Mikro Kecil Menengah',
        content: 'Pemerintah mendukung transformasi digital 30 juta UMKM melalui platform e-commerce, pelatihan kompetensi digital, dan akses pembiayaan.',
        section: 'ekonomi',
        keywords: ['UMKM', 'digital', 'transformasi', 'usaha', 'pasar', 'global']
    },
    {
        id: 'ekonomi-kek',
        title: 'Pengembangan Kawasan Ekonomi Khusus',
        content: 'Pengembangan 15 Kawasan Ekonomi Khusus strategis menarik investasi dan menciptakan pusat pertumbuhan ekonomi baru.',
        section: 'ekonomi',
        keywords: ['kawasan ekonomi', 'ekonomi', 'investasi', 'kawasan', 'industri', 'pertumbuhan']
    },
    {
        id: 'infrastruktur-tollaut',
        title: 'Konektivitas Maritim melalui Tol Laut',
        content: 'Sistem logistik maritim menghubungkan 17.000 pulau Indonesia untuk pemerataan pembangunan dan pertumbuhan ekonomi.',
        section: 'infrastruktur',
        keywords: ['tol laut', 'maritim', 'logistik', 'konektivitas', 'pelabuhan', 'transportasi']
    },
    {
        id: 'infrastruktur-digital',
        title: 'Infrastruktur Digital Nasional',
        content: 'Palapa Ring sebagai tulang punggung digital nasional menghubungkan seluruh wilayah Indonesia dengan jaringan internet berkecepatan tinggi.',
        section: 'infrastruktur',
        keywords: ['digital', 'infrastruktur', 'palapa ring', 'internet', 'konektivitas', 'teknologi']
    },
    {
        id: 'kesehatan-jkn',
        title: 'Jaminan Kesehatan Nasional',
        content: 'Sistem asuransi kesehatan sosial terbesar di dunia dengan lebih dari 230 juta peserta menjamin akses pelayanan kesehatan dasar.',
        section: 'kesehatan',
        keywords: ['jaminan kesehatan', 'kesehatan', 'BPJS', 'asuransi', 'pelayanan', 'universal']
    },
    {
        id: 'kesehatan-primer',
        title: 'Penguatan Layanan Kesehatan Primer',
        content: 'Penguatan 10.000 Puskesmas dan 300.000 Posyandu sebagai garda terdepan sistem kesehatan melalui transformasi digital dan peningkatan kapasitas.',
        section: 'kesehatan',
        keywords: ['puskesmas', 'kesehatan', 'primer', 'pelayanan', 'digital', 'transformasi']
    },
    {
        id: 'lingkungan-netzero',
        title: 'Target Nol Emisi Bersih 2060',
        content: 'Komitmen Indonesia mencapai emisi nol bersih pada tahun 2060 dengan peta jalan transisi energi dan ekonomi hijau.',
        section: 'lingkungan',
        keywords: ['nol emisi', 'emisi', 'lingkungan', 'berkelanjutan', 'iklim', 'energi terbarukan']
    },
    {
        id: 'lingkungan-sirkular',
        title: 'Ekonomi Sirkular dan Pengelolaan Sampah',
        content: 'Transformasi pengelolaan 64 juta ton sampah per tahun dari model linear menuju model sirkular yang bernilai ekonomi.',
        section: 'lingkungan',
        keywords: ['ekonomi sirkular', 'sampah', 'daur ulang', 'lingkungan', 'berkelanjutan', 'konversi sampah']
    },
    {
        id: 'sosial-pkh',
        title: 'Program Keluarga Harapan',
        content: 'Bantuan bersyarat untuk 10 juta keluarga sangat miskin dengan mekanisme yang memberdayakan dan memutus mata rantai kemiskinan.',
        section: 'sosial',
        keywords: ['bantuan sosial', 'kemiskinan', 'pemberdayaan', 'keluarga', 'perlindungan sosial']
    },
    {
        id: 'sosial-kip',
        title: 'Kartu Indonesia Pintar',
        content: 'Akses pendidikan untuk seluruh warga melalui sistem identifikasi terpadu yang menjamin hak dasar.',
        section: 'sosial',
        keywords: ['kartu indonesia pintar', 'pendidikan', 'akses', 'beasiswa', 'siswa', 'perlindungan sosial']
    },
    {
        id: 'hukum-omnibus',
        title: 'Undang-Undang Omnibus dan Penyederhanaan Regulasi',
        content: 'Penataan ulang 79 Undang-Undang dan 1.200 peraturan untuk menciptakan iklim investasi yang kondusif dengan kepastian hukum.',
        section: 'hukum',
        keywords: ['undang-undang omnibus', 'regulasi', 'hukum', 'investasi', 'birokrasi', 'reformasi']
    },
    {
        id: 'hukum-ecourt',
        title: 'Sistem Peradilan Terpadu dan Pengadilan Elektronik',
        content: 'Digitalisasi 800 pengadilan di Indonesia untuk transparansi dan efisiensi proses hukum melalui sistem online terintegrasi.',
        section: 'hukum',
        keywords: ['pengadilan elektronik', 'peradilan', 'digital', 'hukum', 'transparansi', 'pengadilan online']
    },
    {
        id: 'digital-talent',
        title: 'Pengembangan Talenta Digital Indonesia',
        content: 'Pengembangan 9 juta talenta digital berkualitas untuk memenangkan persaingan ekonomi digital global.',
        section: 'digital',
        keywords: ['talenta', 'digital', 'SDM', 'teknologi', 'pelatihan', 'keterampilan']
    },
    {
        id: 'digital-startup',
        title: 'Ekonomi Digital dan Startup Nasional',
        content: 'Menciptakan ekosistem digital yang produktif dengan 10 perusahaan unicorn dan 1 decacorn Indonesia yang berdaya saing global.',
        section: 'digital',
        keywords: ['startup', 'ekonomi digital', 'teknologi', 'inovasi', 'wirausaha', 'digital']
    },
    {
        id: 'energi-ebt',
        title: 'Energi Baru Terbarukan',
        content: 'Pengembangan sumber energi bersih 32 gigawatt kapasitas untuk mengurangi ketergantungan 60% pada bahan bakar fosil.',
        section: 'energi',
        keywords: ['energi terbarukan', 'surya', 'angin', 'panas bumi', 'transisi energi']
    },
    {
        id: 'energi-kendaraan-listrik',
        title: 'Kendaraan Listrik dan Transportasi Bersih',
        content: 'Transformasi sistem transportasi 15 juta unit menuju ramah lingkungan dan efisien energi dengan insentif komprehensif.',
        section: 'energi',
        keywords: ['kendaraan listrik', 'transportasi', 'energi', 'listrik', 'ramah lingkungan', 'EV']
    }
];

// State Management
let currentSection = 'pendidikan';
let searchTimeout = null;
let searchActive = false;

// Show Section Function
function showSection(section) {
    if (searchActive) {
        clearSearch();
    }
    
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(el => {
        el.classList.add('hidden');
    });
    
    // Update active category
    document.querySelectorAll('.category-card').forEach(card => {
        card.classList.remove('active');
        if (card.dataset.category === section) {
            card.classList.add('active');
        }
    });
    
    // Show selected section
    const targetSection = document.getElementById('section-' + section);
    if (targetSection) {
        targetSection.classList.remove('hidden');
        currentSection = section;
        
        // Smooth scroll to content
        targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Explore Random Topic
function exploreRandomTopic() {
    const topics = ['pendidikan', 'ekonomi', 'infrastruktur', 'kesehatan', 'lingkungan', 'sosial', 'hukum', 'digital', 'energi'];
    const currentIndex = topics.indexOf(currentSection);
    let randomIndex;
    
    do {
        randomIndex = Math.floor(Math.random() * topics.length);
    } while (randomIndex === currentIndex);
    
    showSection(topics[randomIndex]);
    showNotification(`✨ Menjelajahi topik: ${getTopicName(topics[randomIndex])}`);
}

function getTopicName(topic) {
    const names = {
        'pendidikan': 'Pendidikan',
        'ekonomi': 'Ekonomi',
        'infrastruktur': 'Infrastruktur',
        'kesehatan': 'Kesehatan',
        'lingkungan': 'Lingkungan',
        'sosial': 'Sosial',
        'hukum': 'Hukum',
        'digital': 'Digital',
        'energi': 'Energi'
    };
    return names[topic] || topic;
}

function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-white border border-green-200 rounded-xl p-4 shadow-lg z-50 max-w-sm animate-fadeIn';
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                <span class="text-green-600 text-sm">✨</span>
            </div>
            <div class="flex-grow">
                <p class="text-sm font-medium text-stone-900">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-stone-400 hover:text-stone-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 3000);
}

// Search Functionality
function setupSearch() {
    const searchInput = document.getElementById('search-material');
    const clearButton = document.getElementById('clear-search');
    
    searchInput.addEventListener('input', function(e) {
        if (e.target.value.trim() !== '') {
            clearButton.classList.remove('hidden');
        } else {
            clearButton.classList.add('hidden');
            clearSearch();
        }
    });
    
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim().toLowerCase();
        
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }
        
        searchTimeout = setTimeout(() => {
            if (query.length < 2) {
                clearSearch();
                return;
            }
            
            performSearch(query);
        }, 300);
    });
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = e.target.value.trim().toLowerCase();
            if (query.length >= 2) {
                performSearch(query);
            }
        }
    });
    
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        clearButton.classList.add('hidden');
        clearSearch();
        searchInput.focus();
    });
}

function performSearch(query) {
    const searchResults = document.getElementById('search-results');
    const resultsContainer = document.getElementById('results-container');
    const mainContent = document.getElementById('content-sections');
    
    const results = searchData.filter(item => {
        const searchText = (item.title + ' ' + item.content + ' ' + item.keywords.join(' ')).toLowerCase();
        return searchText.includes(query);
    });
    
    if (results.length > 0) {
        searchResults.classList.remove('hidden');
        searchResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        resultsContainer.innerHTML = results.map((result, index) => `
            <div class="bg-white rounded-xl p-4 cursor-pointer hover:shadow-md transition-shadow duration-300 border border-stone-100"
                 onclick="showSearchResult('${result.section}')">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center">
                            ${getSectionIcon(result.section)}
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-semibold text-stone-900 mb-1 text-sm">${highlightText(result.title, query)}</h3>
                        <p class="text-stone-600 text-xs mb-2 line-clamp-2">${highlightText(result.content, query)}</p>
                        <div class="flex flex-wrap gap-1">
                            ${result.keywords.slice(0, 3).map(keyword => `
                                <span class="px-2 py-1 bg-stone-100 text-stone-700 rounded-full text-xs">${keyword}</span>
                            `).join('')}
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        
        searchActive = true;
        
    } else {
        searchResults.classList.remove('hidden');
        
        resultsContainer.innerHTML = `
            <div class="bg-white rounded-xl p-6 text-center">
                <div class="text-4xl mb-4">🤔</div>
                <h3 class="text-lg font-semibold text-stone-900 mb-2">Pencarian tidak ditemukan</h3>
                <p class="text-stone-600 text-sm mb-4">Coba kata kunci lain seperti: pendidikan, ekonomi, kesehatan, atau lingkungan</p>
                <button onclick="clearSearch()" class="px-4 py-2 bg-stone-900 text-white rounded-full text-sm font-semibold hover:bg-stone-800 transition">
                    Kembali ke Materi
                </button>
            </div>
        `;
        
        searchActive = true;
    }
}

function highlightText(text, query) {
    if (!query) return text;
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<span class="bg-yellow-200 px-1 rounded">$1</span>');
}

function getSectionIcon(section) {
    const icons = {
        'pendidikan': '🎓',
        'ekonomi': '💰',
        'infrastruktur': '🏗️',
        'kesehatan': '🏥',
        'lingkungan': '🌿',
        'sosial': '👥',
        'hukum': '⚖️',
        'digital': '📱',
        'energi': '⚡'
    };
    return icons[section] || '📄';
}

function showSearchResult(section) {
    document.getElementById('search-results').classList.add('hidden');
    showSection(section);
    searchActive = false;
}

function clearSearch() {
    const searchInput = document.getElementById('search-material');
    const clearButton = document.getElementById('clear-search');
    const searchResults = document.getElementById('search-results');
    
    searchInput.value = '';
    clearButton.classList.add('hidden');
    searchResults.classList.add('hidden');
    searchActive = false;
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    setupSearch();
    
    // Add click handlers to category cards
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            const section = this.dataset.category;
            showSection(section);
        });
    });
    
    // Escape key to clear search
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchActive) {
            clearSearch();
        }
    });
});
</script>
@endsection