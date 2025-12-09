@extends('layout')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center py-12">
    {{-- Skor Utama --}}
    <div class="card-warm p-12 rounded-[40px] text-center max-w-2xl w-full relative overflow-hidden mb-10">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 to-rose-400"></div>

        <h2 class="text-stone-400 uppercase tracking-widest text-xs mb-6 font-bold">Hasil Sertifikasi</h2>
        
        <div class="text-8xl font-bold text-stone-800 mb-2 tracking-tighter">{{ round($final) }}<span class="text-3xl text-stone-300">/100</span></div>
        
        <div class="inline-flex px-6 py-2 bg-stone-100 rounded-full text-stone-600 text-sm font-bold mb-4">
            Predikat: {{ $grade }}
        </div>

        <p class="text-stone-500 text-sm mb-6">
            Benar: {{ $score }} dari {{ $totalMcq }} soal pilihan ganda
        </p>

        <a href="{{ route('home') }}" class="inline-block bg-stone-900 text-white font-bold py-3 px-10 rounded-full hover:bg-orange-600 transition transform hover:scale-105">
            Kembali ke Dashboard
        </a>
    </div>

    {{-- Review Jawaban --}}
    @if(isset($review) && count($review) > 0)
    <div class="w-full max-w-4xl px-4">
        <h3 class="text-2xl font-bold text-stone-800 mb-6 text-center">Review Jawaban</h3>
        
        <div class="space-y-4">
            @foreach($review as $index => $item)
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 {{ $item['is_correct'] ? 'border-green-500' : 'border-red-500' }}">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white {{ $item['is_correct'] ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-stone-800 font-medium text-sm mb-3">{{ $item['question'] }}</p>
                        
                        @if($item['type'] === 'mcq')
                            {{-- MCQ Options --}}
                            <div class="space-y-1 mb-3">
                                @foreach($item['options'] as $key => $option)
                                <div class="flex items-center gap-2 p-2 rounded text-sm
                                    @if($key === $item['correct_answer']) bg-green-100 text-green-800
                                    @elseif($key === $item['user_answer'] && !$item['is_correct']) bg-red-100 text-red-800
                                    @else bg-stone-50 text-stone-600
                                    @endif">
                                    <span class="font-bold w-5">{{ $key }}.</span>
                                    <span class="flex-1">{{ $option }}</span>
                                    @if($key === $item['correct_answer'])
                                        <span class="text-xs font-bold">✓ Benar</span>
                                    @elseif($key === $item['user_answer'] && !$item['is_correct'])
                                        <span class="text-xs font-bold">✗ Jawaban Anda</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="bg-blue-50 p-3 rounded text-xs text-blue-800">
                                <strong>Penjelasan:</strong> {{ $item['explanation'] }}
                            </div>
                        @else
                            {{-- Essay --}}
                            <div class="mb-3">
                                <p class="text-xs text-stone-500 mb-1">Jawaban Anda:</p>
                                <div class="bg-stone-100 p-3 rounded text-sm text-stone-700">
                                    {{ $item['user_answer'] ?: '(Tidak dijawab)' }}
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <p class="text-xs text-stone-500 mb-1">Contoh Jawaban:</p>
                                <div class="bg-green-50 p-3 rounded text-sm text-green-800">
                                    {{ $item['correct_answer'] ?: '-' }}
                                </div>
                            </div>
                            
                            <div class="bg-blue-50 p-3 rounded text-xs text-blue-800">
                                <strong>Kriteria:</strong> {{ $item['explanation'] }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection