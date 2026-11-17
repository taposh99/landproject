<!DOCTYPE html>
<html lang="bn" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'জমিরহাট - নরসিংদী ও পলাশ থানার জমি কেনা-বেচার বিশ্বস্ত প্ল্যাটফর্ম')</title>

    <!-- Google Fonts for Bengali -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Hind Siliguri', system-ui, -apple-system, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        /* Hide scrollbar for clean horizontal scrolls */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased pb-16 md:pb-0" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement Bar (Palash Thana focus) -->
    <div class="bg-emerald-900 text-emerald-100 text-xs py-1.5 px-4 text-center font-medium">
        <span class="inline-flex items-center gap-1.5">
            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            নরসিংদী ও পলাশ থানার জমি বেচা-কেনার বিশেষ সুবিধা চালু হয়েছে! সরাসরি জমির মালিকের সাথে কথা বলুন।
        </span>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-md shadow-emerald-500/20 group-hover:scale-105 transition">
                            <!-- Land / Map icon -->
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold bg-gradient-to-r from-emerald-800 to-teal-700 bg-clip-text text-transparent">জমিরহাট</span>
                            <span class="block text-[10px] text-slate-500 font-semibold tracking-wider uppercase -mt-1">নরসিংদী • পলাশ</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-emerald-700 transition {{ request()->routeIs('home') ? 'text-emerald-700 font-bold' : '' }}">হোম</a>
                    <a href="{{ route('properties.index', ['upazila_id' => 1]) }}" class="hover:text-emerald-700 transition flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        পলাশ থানার জমি
                    </a>
                    <a href="{{ route('properties.index') }}" class="hover:text-emerald-700 transition {{ request()->routeIs('properties.index') && !request()->filled('upazila_id') ? 'text-emerald-700 font-bold' : '' }}">সব জমি</a>
                    <a href="{{ route('converter') }}" class="hover:text-emerald-700 transition {{ request()->routeIs('converter') ? 'text-emerald-700 font-bold' : '' }}">জমি ক্যালকুলেটর</a>
                </nav>

                <!-- Action & User Auth Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Post Land Button -->
                    <a href="{{ route('properties.create') }}" class="hidden sm:inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm transition active:scale-95">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>জমি পোস্ট করুন</span>
                    </a>

                    @auth
                        <!-- User Menu Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition text-left">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-sm">
                                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden lg:block text-xs pr-1">
                                    <p class="font-semibold text-slate-800 leading-tight">{{ Str::limit(Auth::user()->name, 12) }}</p>
                                    <p class="text-[10px] text-emerald-600 font-medium">
                                        @if(Auth::user()->hasRole('admin'))
                                            অ্যাডমিন
                                        @elseif(Auth::user()->hasRole('seller'))
                                            বিক্রেতা
                                        @else
                                            ক্রেতা
                                        @endif
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition.origin.top.right class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                @if(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-4 py-2.5 text-sm text-emerald-700 hover:bg-emerald-50 font-semibold transition">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                            অ্যাডমিন প্যানেল
                                        </span>
                                        @php $pendingCount = \App\Models\Property::where('status', 'pending')->count(); @endphp
                                        @if($pendingCount > 0)
                                            <span class="px-2 py-0.5 text-xs bg-amber-500 text-white rounded-full font-bold">{{ $pendingCount }}</span>
                                        @endif
                                    </a>
                                @endif

                                <a href="{{ route('my.properties') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    আমার জমিসমূহ
                                </a>
                                <a href="{{ route('properties.create') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition sm:hidden">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    নতুন জমি পোস্ট করুন
                                </a>

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition">
                                        <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        লগআউট
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest Auth Buttons -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">লগইন</a>
                            <a href="{{ route('register') }}" class="text-sm font-semibold bg-slate-900 hover:bg-black text-white px-3.5 py-1.5 rounded-xl shadow-sm transition">রেজিস্ট্রেশন</a>
                        </div>
                    @endauth

                    <!-- Mobile Hamburger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!mobileMenuOpen">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="mobileMenuOpen" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Slide-out / Dropdown Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-b border-slate-200 bg-white px-4 pt-3 pb-5 space-y-3">
            <div class="space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-50">হোম</a>
                <a href="{{ route('properties.index', ['upazila_id' => 1]) }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-emerald-800 bg-emerald-50">
                    📍 নরসিংদী - পলাশ থানার জমি
                </a>
                <a href="{{ route('properties.index') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-50">সব জমি ব্রাউজ করুন</a>
                <a href="{{ route('converter') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-50">জমির হিসাব ক্যালকুলেটর</a>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <a href="{{ route('properties.create') }}" class="w-full flex items-center justify-center gap-2 bg-emerald-600 text-white font-semibold py-2.5 rounded-xl shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    জমি পোস্ট করুন
                </a>
            </div>
        </div>
    </header>

    <!-- Global Alert Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 mb-4 text-emerald-900 bg-emerald-50 rounded-2xl border border-emerald-200 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="flex items-center gap-3 p-4 mb-4 text-amber-900 bg-amber-50 rounded-2xl border border-amber-200 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="text-sm font-medium">{{ session('warning') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center gap-3 p-4 mb-4 text-rose-900 bg-rose-50 rounded-2xl border border-rose-200 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Body Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Bottom Navigation Bar for Mobile (App-like feel) -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur border-t border-slate-200 py-1.5 px-4">
        <div class="flex items-center justify-around">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 text-xs font-semibold {{ request()->routeIs('home') ? 'text-emerald-700' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>হোম</span>
            </a>

            <a href="{{ route('properties.index') }}" class="flex flex-col items-center gap-0.5 text-xs font-semibold {{ request()->routeIs('properties.index') ? 'text-emerald-700' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>খুঁজুন</span>
            </a>

            <!-- Central Post Button -->
            <a href="{{ route('properties.create') }}" class="flex flex-col items-center -mt-5">
                <div class="w-12 h-12 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-600/30 active:scale-95 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-800 mt-0.5">পোস্ট</span>
            </a>

            <a href="{{ route('converter') }}" class="flex flex-col items-center gap-0.5 text-xs font-semibold {{ request()->routeIs('converter') ? 'text-emerald-700' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <span>ক্যালকুলেটর</span>
            </a>

            @auth
                <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('my.properties') }}" class="flex flex-col items-center gap-0.5 text-xs font-semibold {{ request()->routeIs('my.properties') || request()->routeIs('admin.*') ? 'text-emerald-700' : 'text-slate-500' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>অ্যাকাউন্ট</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center gap-0.5 text-xs font-semibold {{ request()->routeIs('login') ? 'text-emerald-700' : 'text-slate-500' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span>লগইন</span>
                </a>
            @endauth
        </div>
    </div>

    <!-- Desktop Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-12 pb-8 border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-slate-800">
                <!-- Col 1 -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-bold">
                            জ
                        </div>
                        <span class="text-xl font-bold text-white">জমিরহাট</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        নরসিংদী জেলা ও পলাশ থানার জমি কেনা-বেচার জন্য একটি আধুনিক, সুরক্ষিত ও বিশ্বস্ত প্ল্যাটফর্ম। সরাসরি মালিকের সাথে কথা বলে জমি কেনার সুবিধা।
                    </p>
                </div>

                <!-- Col 2 -->
                <div>
                    <h4 class="text-sm font-bold text-white mb-3">দ্রুত লিঙ্ক</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">হোম পেজ</a></li>
                        <li><a href="{{ route('properties.index', ['upazila_id' => 1]) }}" class="hover:text-emerald-400 transition">পলাশ থানার জমি</a></li>
                        <li><a href="{{ route('properties.index') }}" class="hover:text-emerald-400 transition">সকল লিস্টিং</a></li>
                        <li><a href="{{ route('converter') }}" class="hover:text-emerald-400 transition">জমির পরিমাপ ক্যালকুলেটর</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div>
                    <h4 class="text-sm font-bold text-white mb-3">জমির ক্যাটাগরি</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('properties.index', ['land_type' => 'residential']) }}" class="hover:text-emerald-400 transition">আবাসিক প্লট / বাড়ি করার জমি</a></li>
                        <li><a href="{{ route('properties.index', ['land_type' => 'commercial']) }}" class="hover:text-emerald-400 transition">বাণিজ্যিক জমি ও দোকান</a></li>
                        <li><a href="{{ route('properties.index', ['land_type' => 'agricultural']) }}" class="hover:text-emerald-400 transition">কৃষি ও নাল জমি</a></li>
                        <li><a href="{{ route('properties.index', ['land_type' => 'industrial']) }}" class="hover:text-emerald-400 transition">শিল্প কারখানার উপযোগী জমি</a></li>
                    </ul>
                </div>

                <!-- Col 4 -->
                <div>
                    <h4 class="text-sm font-bold text-white mb-3">জরুরি হেল্পলাইন</h4>
                    <p class="text-xs text-slate-400 mb-2">যে কোনো তথ্যের জন্য যোগাযোগ করুন:</p>
                    <p class="text-sm font-bold text-emerald-400">📞 ০১৮১২-৩৪৫৬৭৮</p>
                    <p class="text-xs text-slate-400 mt-1">ইমেইল: support@landproject.com</p>
                    <div class="mt-4 p-2.5 rounded-xl bg-slate-800 text-[11px] text-slate-400 border border-slate-700">
                        🛡️ সকল জমি অ্যাডমিন দ্বারা ম্যানুয়ালি যাচাই করার পরই লাইভ করা হয়।
                    </div>
                </div>
            </div>

            <div class="pt-6 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} জমিরহাট (LandProject). সর্বস্বত্ব সংরক্ষিত।
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

