<?php
/**
 * ==========================================================
 * layout.php - Template Layout Utama
 * ==========================================================
 * 
 * FUNGSI:
 * File ini adalah template induk yang membungkus semua halaman.
 * Menyediakan struktur HTML, loading CSS/JS (Tailwind & AlpineJS via CDN),
 * navigasi sidebar, dan area konten dinamis.
 * 
 * VARIABEL YANG DITERIMA:
 * - $pageTitle    : Judul halaman (untuk <title> dan heading)
 * - $contentView  : Path ke file view yang akan di-include sebagai konten
 * 
 * STACK UI:
 * - Tailwind CSS v3 (CDN) untuk styling utility-first
 * - AlpineJS v3 (CDN) untuk interaktivitas ringan (modal, toggle, dll.)
 * - Google Fonts (Inter) untuk tipografi modern
 */
?>
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Buah - UTS Pemrograman Berorientasi Objek">
    
    <!-- Judul Halaman Dinamis -->
    <title><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?> — Fruit Manager</title>
    
    <!-- Google Fonts: Inter untuk tampilan modern -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS v3 via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Konfigurasi Tailwind agar menggunakan font Inter dan warna kustom
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        // Palet warna kustom yang harmonis
                        brand: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        surface: {
                            50:  '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- AlpineJS v3 via CDN untuk interaktivitas -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        /* Animasi fade-in untuk konten */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Animasi slide-in untuk sidebar */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .animate-slide-in {
            animation: slideInLeft 0.4s ease-out forwards;
        }

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transition untuk semua elemen interaktif */
        a, button, input, select, textarea {
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="h-full font-sans bg-gradient-to-br from-surface-50 via-brand-50/30 to-surface-100 text-surface-800 antialiased">

    <!-- ============================================ -->
    <!-- LAYOUT UTAMA: Sidebar + Konten              -->
    <!-- Menggunakan Alpine.js untuk toggle sidebar   -->
    <!-- ============================================ -->
    <div x-data="{ sidebarOpen: true }" class="flex h-full">

        <!-- ======================================== -->
        <!-- SIDEBAR NAVIGASI                        -->
        <!-- ======================================== -->
        <aside 
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 -translate-x-full"
            class="fixed inset-y-0 left-0 z-30 w-72 bg-surface-900 text-white shadow-2xl flex flex-col lg:relative"
        >
            <!-- Logo & Brand -->
            <div class="px-6 py-8 border-b border-surface-700/50">
                <div class="flex items-center gap-3">
                    <!-- Icon Buah (Emoji sebagai logo) -->
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-2xl shadow-lg shadow-brand-500/30">
                        🍎
                    </div>
                    <div>
                        <h1 class="text-lg font-bold tracking-tight">Fruit Manager</h1>
                        <p class="text-xs text-surface-200/60 font-medium">UTS PBO System</p>
                    </div>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-3 mb-3 text-[10px] font-bold uppercase tracking-widest text-surface-200/40">Menu Utama</p>
                
                <!-- Link Dashboard -->
                <a href="index.php?action=index" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                          <?= ($pageTitle === 'Dashboard') 
                              ? 'bg-brand-500/20 text-brand-400 shadow-inner' 
                              : 'text-surface-200/70 hover:bg-surface-800 hover:text-white' ?>
                          transition-all duration-200"
                   id="nav-dashboard">
                    <!-- Icon SVG: Grid -->
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
            </nav>

            <!-- Footer Sidebar -->
            <div class="px-6 py-4 border-t border-surface-700/50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-emerald-500 flex items-center justify-center text-sm font-bold text-white">
                        M
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-surface-200">M. Kelvin M.F</p>
                        <p class="text-[11px] text-surface-200/50">Semester 4 - PBO</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ======================================== -->
        <!-- AREA KONTEN UTAMA                       -->
        <!-- ======================================== -->
        <main class="flex-1 flex flex-col min-h-screen overflow-x-hidden" :class="sidebarOpen ? 'lg:ml-0' : ''">
            
            <!-- Top Bar -->
            <header class="sticky top-0 z-20 glass border-b border-surface-200/50">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-4">
                        <!-- Tombol Toggle Sidebar -->
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="p-2 rounded-xl hover:bg-surface-200/60 text-surface-700 transition-colors"
                                id="btn-toggle-sidebar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-xl font-bold text-surface-900"><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></h2>
                            <p class="text-xs text-surface-700/50 font-medium">Sistem Manajemen Buah — UTS PBO</p>
                        </div>
                    </div>
                    
                    <!-- Badge Info -->
                    <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-50 border border-brand-200/50">
                        <div class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></div>
                        <span class="text-xs font-semibold text-brand-700">PHP 8.3 • MySQL • MVC</span>
                    </div>
                </div>
            </header>

            <!-- Flash Messages (Notifikasi sukses/error) -->
            <?php if (isset($_SESSION['flash'])): ?>
                <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 4000)"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="mx-6 mt-4">
                    <div class="flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg
                                <?= $flash['type'] === 'success' 
                                    ? 'bg-gradient-to-r from-brand-500 to-emerald-500 text-white' 
                                    : 'bg-gradient-to-r from-red-500 to-rose-500 text-white' ?>">
                        <!-- Icon Sukses / Error -->
                        <?php if ($flash['type'] === 'success'): ?>
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        <?php else: ?>
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        <?php endif; ?>
                        <span class="text-sm font-medium"><?= htmlspecialchars($flash['message']) ?></span>
                        <!-- Tombol Tutup -->
                        <button @click="show = false" class="ml-auto p-1 rounded-lg hover:bg-white/20 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Area Konten Dinamis -->
            <div class="flex-1 p-6 animate-fade-in-up">
                <?php 
                // Include view konten sesuai dengan halaman yang diminta
                if (isset($contentView) && file_exists($contentView)) {
                    require $contentView;
                }
                ?>
            </div>

            <!-- Footer -->
            <footer class="px-6 py-4 border-t border-surface-200/50 text-center">
                <p class="text-xs text-surface-700/40 font-medium">
                    &copy; <?= date('Y') ?> Fruit Management System — UTS Pemrograman Berorientasi Objek (PBO)
                </p>
            </footer>
        </main>
    </div>

</body>
</html>
