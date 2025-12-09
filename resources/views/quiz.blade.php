@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Header Intro -->
    <div class="text-center py-10 mb-10 border-b border-stone-200">
        <span class="inline-block px-4 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-bold uppercase tracking-widest mb-4">
            Uji Kompetensi
        </span>
        <h1 class="text-4xl font-bold text-stone-900 mb-4">Logika & Analisis Kebijakan</h1>
        <p class="text-stone-500 text-lg max-w-2xl mx-auto">
            Uji kemampuan analisis kritis Anda terhadap 40 skenario kebijakan publik. Soal diacak setiap sesi untuk menjamin keaslian pengujian.
        </p>
    </div>

    <form action="{{ route('submit') }}" method="POST" class="space-y-16">
        @csrf
        
        <!-- BAGIAN 1: PILIHAN GANDA (40 Soal) -->
        <div>
            <div class="flex items-center gap-4 mb-8">
                <div class="h-px bg-stone-300 flex-1"></div>
                <h2 class="text-xl font-bold text-stone-800 uppercase tracking-widest">Bagian I: Pilihan Ganda</h2>
                <div class="h-px bg-stone-300 flex-1"></div>
            </div>

            <div class="space-y-10">
                @foreach($mcqs as $i => $q)
                <div class="card-warm p-8 rounded-[24px] relative">
                    <span class="absolute top-6 right-6 text-stone-200 text-4xl font-black opacity-20">{{ $i+1 }}</span>
                    
                    <p class="text-lg text-stone-800 mb-6 font-bold leading-relaxed pr-8">
                        {{ $q->question_text }}
                    </p>
                    
                    <div class="grid grid-cols-1 gap-3">
                        @foreach(json_decode($q->options) as $key => $val)
                        <label class="flex items-start p-4 rounded-xl bg-stone-50 hover:bg-orange-50 cursor-pointer transition border border-transparent hover:border-orange-200 group">
                            <input type="radio" name="ans[{{ $q->id }}]" value="{{ $key }}" class="mt-1 text-orange-600 focus:ring-orange-500 bg-white border-stone-300" required>
                            <span class="ml-3 text-sm text-stone-600 group-hover:text-stone-900 transition leading-snug">
                                <strong class="text-stone-900 mr-1">{{ $key }}.</strong> {{ $val }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- BAGIAN 2: ESSAY LOGIKA (10 Soal) -->
        <div>
            <div class="flex items-center gap-4 mb-8 mt-16">
                <div class="h-px bg-stone-300 flex-1"></div>
                <h2 class="text-xl font-bold text-stone-800 uppercase tracking-widest">Bagian II: Esai Analisis</h2>
                <div class="h-px bg-stone-300 flex-1"></div>
            </div>

            <div class="space-y-8">
                @foreach($essays as $j => $e)
                <div class="card-warm p-8 rounded-[24px] border-l-4 border-stone-800">
                    <p class="text-lg text-stone-800 mb-4 font-bold">
                        <span class="text-stone-400 mr-2">#{{ $j+1 }}</span> {{ $e->question_text }}
                    </p>
                    <textarea name="essay[{{ $e->id }}]" rows="4" class="w-full bg-white border border-stone-200 rounded-xl p-4 text-stone-700 focus:ring-2 focus:ring-stone-800 focus:border-transparent outline-none transition font-medium text-sm" placeholder="Ketik analisis logika Anda di sini..."></textarea>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="sticky bottom-6 text-center pt-6 pb-10 z-30">
            <div class="inline-block bg-white/80 backdrop-blur-md p-2 rounded-full shadow-2xl border border-white/40">
                <button class="bg-stone-900 text-white font-bold py-4 px-20 rounded-full hover:bg-orange-600 hover:scale-105 transition transform shadow-lg text-lg tracking-wide">
                    Selesai & Lihat Skor
                </button>
            </div>
        </div>
    </form>
</div>
@endsection