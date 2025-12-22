<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Gressoy') }} - Sistem Manajemen Stok</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { margin: 0; padding: 0; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex-shrink-0">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800">Gressoy</h1>
                <p class="text-sm text-gray-500 mt-1">Sistem Manajemen Stok</p>
                
                <div class="mt-5 flex items-center">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-gray-600 font-semibold text-lg">E</span>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">Erlangfa@gmail.com</p>
                        <p class="text-xs text-gray-500 truncate">Shanyosha Erland Wijayama</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-2">
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('keuangan.index') }}" class="flex items-center px-4 py-3 bg-green-500 text-white rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Keuangan</span>
                </a>
                
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="font-medium">Bahan Baku</span>
                </a>
                
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium">Laporan</span>
                </a>
                
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">Pengaturan</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-gray-200">
                    <a href="#" class="flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="font-medium">Keluar</span>
                    </a>
                </div>
            </nav>
        </aside>

        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>