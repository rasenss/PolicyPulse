<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PolicyPulse | Education Platform</title>
    <link rel="icon" href="{{ asset('2.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- NProgress (Loading Bar ala YouTube) -->
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css" />

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #FDFCF8; 
            color: #1c1917; 
            min-height: 100vh;
        }
        
        .card-warm { 
            background: #ffffff; 
            border: 1px solid #e7e5e4;
            box-shadow: 0 4px 20px -2px rgba(28, 25, 23, 0.05);
        }
        .card-warm:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(28, 25, 23, 0.08);
            border-color: #d6d3d1;
            transition: all 0.3s ease;
        }
        .nav-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        /* Custom Loading Bar Color (Orange) */
        #nprogress .bar { background: #ea580c !important; height: 3px !important; }
        #nprogress .peg { box-shadow: 0 0 10px #ea580c, 0 0 5px #ea580c; }
        #nprogress .spinner-icon { border-top-color: #ea580c; border-left-color: #ea580c; }
    </style>
</head>
<body class="antialiased selection:bg-stone-200 selection:text-black">

    <nav class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-[90%] max-w-3xl">
        <div class="nav-glass rounded-full px-6 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3 opacity-80 hover:opacity-100 transition">
                <img src="{{ asset('1.png') }}" alt="Logo" class="h-6 invert-0">
            </a>
            
            <div class="flex items-center gap-1 bg-stone-100 rounded-full p-1">
                <a href="{{ route('home') }}" class="px-5 py-2 rounded-full text-xs font-bold transition {{ Request::routeIs('home') || Request::routeIs('policy') ? 'bg-white text-black shadow-sm' : 'text-stone-500 hover:text-stone-800' }}">
                    Policies
                </a>
                <a href="{{ route('quiz') }}" class="px-5 py-2 rounded-full text-xs font-bold transition {{ Request::routeIs('quiz') ? 'bg-white text-black shadow-sm' : 'text-stone-500 hover:text-stone-800' }}">
                    Education Quiz
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-20 container mx-auto px-6 max-w-6xl">
        @yield('content')
    </main>

    <footer class="text-center pb-10 text-stone-400 text-[10px] uppercase tracking-widest font-medium">
        PolicyPulse © 2025 • Universitas Siber Muhammadiyah
    </footer>

    <script>
        // Script agar Loading Bar muncul saat pindah halaman
        document.addEventListener('DOMContentLoaded', () => {
            // Saat klik link
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('click', (e) => {
                    // Jika link internal, jalankan loading
                    if(link.hostname === window.location.hostname && !link.target) {
                        NProgress.start();
                    }
                });
            });

            // Saat submit form
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', () => {
                    NProgress.start();
                });
            });
        });

        // Stop loading saat halaman selesai dimuat (Browser Back Button support)
        window.addEventListener('pageshow', function(event) {
            NProgress.done();
        });
    </script>
</body>
</html>