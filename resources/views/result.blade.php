@extends('layout')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="card-warm p-12 rounded-[40px] text-center max-w-2xl w-full relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 to-rose-400"></div>

        <h2 class="text-stone-400 uppercase tracking-widest text-xs mb-6 font-bold">Hasil Sertifikasi</h2>
        
        <div class="text-8xl font-bold text-stone-800 mb-2 tracking-tighter">{{ round($final) }}<span class="text-3xl text-stone-300">/100</span></div>
        
        <div class="inline-flex px-6 py-2 bg-stone-100 rounded-full text-stone-600 text-sm font-bold mb-8">
            Predikat: {{ $grade }}
        </div>

        <p class="text-stone-500 mb-10 leading-relaxed">
            Terima kasih telah menyelesaikan modul. Pemahaman Anda tentang literasi politik adalah kunci demokrasi yang sehat.
        </p>

        <a href="{{ route('home') }}" class="inline-block bg-stone-900 text-white font-bold py-3 px-10 rounded-full hover:bg-orange-600 transition transform hover:scale-105">
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection