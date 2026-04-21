<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - UTS PWL</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .bg-navy { background-color: #1e3a5f; }
        .text-navy { color: #1e3a5f; }
        .bg-orange-custom { background-color: #f97316; }
        .hover-orange:hover { background-color: #ea580c; }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-navy text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="p-2 bg-orange-custom rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight">POS <span class="text-orange-400">System</span></span>
            </a>
            
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="hover:text-orange-400 transition-colors {{ Request::routeIs('home') ? 'text-orange-400 font-semibold' : '' }}">Home</a>
                <a href="{{ route('pos.index') }}" class="hover:text-orange-400 transition-colors {{ Request::routeIs('pos.*') ? 'text-orange-400 font-semibold' : '' }}">Kasir</a>
                <a href="{{ route('laporan.penjualan') }}" class="hover:text-orange-400 transition-colors {{ Request::routeIs('laporan.penjualan') ? 'text-orange-400 font-semibold' : '' }}">Laporan Penjualan</a>
                <a href="{{ route('laporan.stok') }}" class="hover:text-orange-400 transition-colors {{ Request::routeIs('laporan.stok') ? 'text-orange-400 font-semibold' : '' }}">Laporan Stok</a>
                <a href="/admin" class="px-4 py-1.5 bg-navy border border-orange-400 text-orange-400 rounded-md hover:bg-orange-400 hover:text-navy transition-all font-medium">Dashboard Admin</a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="text-white hover:text-orange-400 focus:outline-none">
                    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M4 5h16a1 1 0 010 2H4a1 1 0 110-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">© 2026 POS System UTS PWL TI-2C. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
