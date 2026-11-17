@extends('layouts.app')

@section('title', 'জমির তালিকা - নরসিংদী ও পলাশ উপজেলার জমি সমূহ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ mobileFilterOpen: false }">
    
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <nav class="flex items-center gap-1.5 text-xs text-slate-500 mb-1">
                <a href="{{ route('home') }}" class="hover:text-emerald-700">হোম</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">জমির তালিকা</span>
                @if($selectedUpazila)
                    <span>/</span>
                    <span class="text-emerald-700 font-bold">{{ $selectedUpazila->bn_name }}</span>
                @endif
            </nav>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">
                @if($selectedUpazila)
                    {{ $selectedUpazila->bn_name }} থানার জমি সমূহ
                @else
                    নরসিংদী ও অন্যান্য এলাকার সকল জমি
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">মোট {{ $properties->total() }} টি জমি পাওয়া গেছে</p>
        </div>

        <!-- Mobile Filter Toggle Button -->
        <div class="flex items-center gap-2 lg:hidden">
            <button @click="mobileFilterOpen = !mobileFilterOpen" class="w-full flex items-center justify-center gap-2 bg-white border border-slate-300 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 shadow-sm active:bg-slate-50">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span>ফিল্টার ও সার্চ</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Filter Sidebar (Desktop and Mobile Drawer) -->
        <aside 
            :class="mobileFilterOpen ? 'fixed inset-0 z-50 bg-black/50 p-4 flex items-center justify-center' : 'hidden lg:block'"
            class="transition-all"
        >
            <div 
                class="bg-white rounded-3xl border border-slate-200 p-5 shadow-sm w-full max-w-md lg:max-w-none max-h-[90vh] overflow-y-auto"
                @click.outside="mobileFilterOpen = false"
            >
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <h3 class="font-black text-slate-900 text-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        ফিল্টার অপশন
                    </h3>
                    <button @click="mobileFilterOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600 text-sm font-bold">
                        ✕ বন্ধ
                    </button>
                </div>

                <form action="{{ route('properties.index') }}" method="GET" class="space-y-4">
                    <!-- Keyword Search -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">কীওয়ার্ড বা এলাকা</label>
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}" 
                            placeholder="যেমন: ঘোড়াশাল, ডাঙ্গা..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                    </div>

                    <!-- District -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">জেলা</label>
                        <select name="district_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">সকল জেলা</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                    {{ $district->bn_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Upazila / Thana (Palash priority) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">উপজেলা / থানা</label>
                        <select name="upazila_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">সকল থানা</option>
                            @foreach($districts->firstWhere('name', 'Narsingdi')?->upazilas ?? [] as $upz)
                                <option value="{{ $upz->id }}" {{ request('upazila_id') == $upz->id ? 'selected' : '' }}>
                                    {{ $upz->bn_name }} {{ $upz->name === 'Palash' ? '⭐' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Land Type -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">জমির ধরন</label>
                        <select name="land_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">সব ধরনের</option>
                            <option value="residential" {{ request('land_type') == 'residential' ? 'selected' : '' }}>🏡 আবাসিক জমি</option>
                            <option value="commercial" {{ request('land_type') == 'commercial' ? 'selected' : '' }}>🏬 বাণিজ্যিক জমি</option>
                            <option value="agricultural" {{ request('land_type') == 'agricultural' ? 'selected' : '' }}>🌾 কৃষি/নাল জমি</option>
                            <option value="industrial" {{ request('land_type') == 'industrial' ? 'selected' : '' }}>🏭 শিল্প কারখানা</option>
                        </select>
                    </div>

                    <!-- Verified Only Checkbox -->
                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="verified_only" 
                                value="1" 
                                {{ request('verified_only') ? 'checked' : '' }}
                                class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            >
                            <span class="text-xs font-bold text-slate-700">শুধু ভেরিফাইড জমি</span>
                        </label>
                    </div>

                    <!-- Sorting -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">সাজান (Sorting)</label>
                        <select name="sort" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>নতুন পোস্ট আগে</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>দাম: কম থেকে বেশি</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>দাম: বেশি থেকে কম</option>
                            <option value="size_desc" {{ request('sort') == 'size_desc' ? 'selected' : '' }}>জমির মাপ: বড় থেকে ছোট</option>
                        </select>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex gap-2">
                        <button type="submit" class="flex-grow bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow-sm transition">
                            ফিল্টার প্রয়োগ করুন
                        </button>
                        <a href="{{ route('properties.index') }}" class="p-2.5 text-center text-xs font-bold text-slate-500 hover:text-slate-800 bg-slate-100 rounded-xl">
                            রিসেট
                        </a>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Properties Grid -->
        <main class="lg:col-span-3">
            @if($properties->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $property)
                        <x-property-card :property="$property" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">কোনো জমি খুঁজে পাওয়া যায়নি</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">
                        আপনার দেওয়া ফিল্টারের সাথে মিলে এমন কোনো জমি নেই। ফিল্টার রিসেট করে আবার চেষ্টা করুন।
                    </p>
                    <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-1.5 bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm">
                        সকল জমি দেখুন
                    </a>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection

