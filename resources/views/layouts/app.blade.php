<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ERP PT. Maju Jaya')</title>

    @yield('meta')

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563EB',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>

<body class="text-slate-800 antialiased bg-slate-50 flex flex-col min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-bold text-xl">
                        M</div>
                    <div class="hidden md:block">
                        <h1 class="text-lg font-bold text-slate-900 leading-none">MAJU JAYA</h1>
                        <p class="text-[10px] text-slate-500 font-semibold uppercase">ERP System</p>
                    </div>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                        <i class="fa-solid fa-chart-pie"></i> Dashboard
                    </a>

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('barang.index') }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('barang*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                            <i class="fa-solid fa-box-open"></i> Data Barang
                        </a>
                    @endif

                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('laporan*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                        <i class="fa-solid fa-print"></i> Laporan
                    </a>

                    <a href="{{ route('transaksi.create') }}"
                        class="flex items-center gap-2 px-5 py-2.5 ml-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-md transition">
                        <i class="fa-solid fa-plus"></i> Transaksi
                    </a>

                    <div class="flex items-center pl-4 ml-2 border-l border-slate-200">
                        <span class="text-sm font-bold text-slate-700 mr-2">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-500 transition">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mobile Button --}}
                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-btn" class="text-slate-500 hover:text-primary p-2">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 p-4">
            <a href="{{ route('dashboard') }}" class="block py-2 text-slate-600 font-medium">Dashboard</a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('barang.index') }}" class="block py-2 text-slate-600 font-medium">Data Barang</a>
            @endif

            <a href="{{ route('laporan.index') }}" class="block py-2 text-slate-600 font-medium">Laporan</a>
            <a href="{{ route('transaksi.create') }}" class="block py-2 text-primary font-bold mt-2">+ Transaksi</a>

            <form action="{{ route('logout') }}" method="POST" class="mt-4 border-t pt-2">
                @csrf
                <button type="submit" class="text-red-500 text-sm font-bold">Logout</button>
            </form>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        @yield('content')
    </main>

    {{-- Scripts --}}
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>
