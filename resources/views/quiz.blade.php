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
            Modul ini menguji nalar kritis Anda dalam membedah dampak kebijakan publik menggunakan logika ekonomi dan sosiologi.
        </p>
    </div>

    <form action="{{ route('submit') }}" method="POST" class="space-y-12">
        @csrf
        
        <!-- BAGIAN 1: PILIHAN GANDA -->
        <div>
            <div class="flex items-center gap-4 mb-6">
                <div class="h-px bg-stone-300 flex-1"></div>
                <h2 class="text-xl font-bold text-stone-800 uppercase tracking-widest">Bagian I: Logika Dasar (40 Soal)</h2>
                <div class="h-px bg-stone-300 flex-1"></div>
            </div>

            <div class="space-y-8">
                @foreach($mcqs as $i => $q)
                <div class="card-warm p-8 rounded-[24px]">
                    <div class="flex gap-4">
                        <span class="flex-shrink-0 w-8 h-8 rounded-full bg-stone-900 text-white flex items-center justify-center font-bold text-sm mt-1">
                            {{ $i+1 }}
                        </span>
                        <div class="w-full">
                            <p class="text-lg text-stone-800 mb-6 font-medium">
                                {{ $q->question_text }}
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach(json_decode($q->options) as $key => $val)
                                <label class="flex items-center p-4 rounded-xl bg-stone-50 hover:bg-stone-100 cursor-pointer transition border border-transparent hover:border-stone-300 group">
                                    <input type="radio" name="ans[{{ $q->id }}]" value="{{ $key }}" class="text-stone-900 focus:ring-stone-500 bg-transparent border-stone-400" required>
                                    <span class="ml-3 text-sm text-stone-600 group-hover:text-stone-900 transition">
                                        <strong class="text-stone-900 mr-2">{{ $key }}.</strong> {{ $val }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- BAGIAN 2: ESSAY LOGIKA -->
        <div>
            <div class="flex items-center gap-4 mb-6 mt-16">
                <div class="h-px bg-stone-300 flex-1"></div>
                <h2 class="text-xl font-bold text-stone-800 uppercase tracking-widest">Bagian II: Logika Kritis (10 Soal)</h2>
                <div class="h-px bg-stone-300 flex-1"></div>
            </div>

            <div class="space-y-8">
                @foreach($essays as $j => $e)
                <div class="card-warm p-8 rounded-[24px] border-l-4 border-orange-400">
                    <p class="text-lg text-stone-800 mb-4 font-bold">
                        <span class="text-orange-500 mr-2">Soal {{ $j+1 }}.</span> {{ $e->question_text }}
                    </p>
                    <!-- Placeholder dikosongkan sesuai permintaan -->
                    <textarea name="essay[{{ $e->id }}]" rows="5" class="w-full bg-stone-50 border border-stone-200 rounded-xl p-4 text-stone-700 focus:ring-2 focus:ring-orange-400 focus:border-transparent outline-none transition font-medium" placeholder=""></textarea>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="sticky bottom-6 text-center pt-6 pb-10">
            <div class="inline-block bg-white/80 backdrop-blur p-2 rounded-full shadow-2xl border border-white/20">
                <button class="bg-stone-900 text-white font-bold py-4 px-16 rounded-full hover:bg-orange-600 transition transform hover:scale-105 shadow-lg text-lg">
                    Selesai & Kirim Jawaban
                </button>
            </div>
        </div>
    </form>
</div>
@endsection