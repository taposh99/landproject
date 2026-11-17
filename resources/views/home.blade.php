@extends('layouts.app')

@section('title', 'জমিরহাট - নরসিংদী ও পলাশ থানার জমি বেচা-কেনার সেরা প্ল্যাটফর্ম')

@section('content')
<!-- Hero Section with Search Form -->
<section class="relative bg-gradient-to-b from-emerald-900 via-emerald-800 to-teal-900 text-white pt-10 pb-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Background subtle pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>

    <div class="relative max-w-5xl mx-auto text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-emerald-700/60 backdrop-blur border border-emerald-500/40 text-emerald-200 text-xs font-semibold px-3 py-1 rounded-full mb-4">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            নরসিংদী ও পলাশ উপজেলার বিশেষায়িত প্রপার্টি প্ল্যাটফর্ম
        </div>

        <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-tight text-white mb-4">
            পলাশ ও নরসিংদীতে জমি খুঁজুন,<br class="hidden sm:inline">
            <span class="text-emerald-300">নিরাপদে ও যাচাই করে</span> কিনুন
        </h1>
        <p class="text-xs sm:text-base text-emerald-100 max-w-2xl mx-auto mb-8 leading-relaxed">
            ঘোড়াশাল, চরসিন্দুর, ডাঙ্গা, জিনারদী ও আশেপাশের এলাকার আবাসিক, বাণিজ্যিক ও কৃষি জমি। অ্যাডমিন দ্বারা ভেরিফাইড এবং সরাসরি মালিকের সাথে যোগাযোগের সুবিধা।
        </p>

        <!-- Search Box -->
        <div class="bg-white text-slate-800 p-3 sm:p-5 rounded-3xl shadow-2xl border border-white/20 max-w-4xl mx-auto text-left">
            <form action="{{ route('properties.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                
                <!-- District -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">জেলা নির্বাচন</label>
                    <select name="district_id" id="district_select" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ $district->name === 'Narsingdi' ? 'selected' : '' }}>
                                {{ $district->bn_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Upazila / Thana (Default Palash) -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">উপজেলা / থানা</label>
                    <select name="upazila_id" id="upazila_select" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">সকল থানা</option>
                        @if($palashUpazila)
                            <option value="{{ $palashUpazila->id }}" selected>
                                📍 {{ $palashUpazila->bn_name }} (নির্বাচিত)
                            </option>
                        @endif
                        @foreach($districts->firstWhere('name', 'Narsingdi')?->upazilas ?? [] as $upz)
                            @if(!$palashUpazila || $upz->id !== $palashUpazila->id)
                                <option value="{{ $upz->id }}">{{ $upz->bn_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Land Type -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">জমির ধরন</label>
                    <select name="land_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">সব ধরনের জমি</option>
                        <option value="residential">🏡 আবাসিক প্লট / বাড়ি</option>
                        <option value="commercial">🏬 বাণিজ্যিক / দোকান</option>
                        <option value="agricultural">🌾 কৃষি / নাল জমি</option>
                        <option value="industrial">🏭 শিল্প কারখানা প্লট</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-md transition active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>জমি খুঁজুন</span>
                    </button>
                </div>
            </form>

            <!-- Quick Filter Tags -->
            <div class="mt-3 pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2 text-xs">
                <span class="font-bold text-slate-500">জনপ্রিয় এলাকা:</span>
                <a href="{{ route('properties.index', ['upazila_id' => $palashUpazila?->id, 'q' => 'ঘোড়াশাল']) }}" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-medium transition">ঘোড়াশাল</a>
                <a href="{{ route('properties.index', ['upazila_id' => $palashUpazila?->id, 'q' => 'চরসিন্দুর']) }}" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-medium transition">চরসিন্দুর বাজার</a>
                <a href="{{ route('properties.index', ['upazila_id' => $palashUpazila?->id, 'q' => 'ডাঙ্গা']) }}" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-medium transition">ডাঙ্গা শিল্পাঞ্চল</a>
                <a href="{{ route('properties.index', ['upazila_id' => $palashUpazila?->id, 'q' => 'জিনারদী']) }}" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-medium transition">জিনারদী</a>
            </div>
        </div>

        <!-- Trust Stats Counter -->
        <div class="grid grid-cols-3 gap-3 max-w-xl mx-auto mt-8 pt-4 border-t border-emerald-700/40 text-center">
            <div>
                <p class="text-xl sm:text-2xl font-black text-white">{{ $stats['palash_lands'] }} টি</p>
                <p class="text-[11px] sm:text-xs text-emerald-200">পলাশ থানার জমি</p>
            </div>
            <div>
                <p class="text-xl sm:text-2xl font-black text-white">{{ $stats['verified_lands'] }} টি</p>
                <p class="text-[11px] sm:text-xs text-emerald-200">ভেরিফাইড ও নিষ্কন্টক</p>
            </div>
            <div>
                <p class="text-xl sm:text-2xl font-black text-white">১০০%</p>
                <p class="text-[11px] sm:text-xs text-emerald-200">সরাসরি মালিকের সাথে</p>
            </div>
        </div>
    </div>
</section>

<!-- Special Palash Thana Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-2">
        <div>
            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                পলাশ স্পেশাল লিস্টিং
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900">
                পলাশ থানার জমি কেনা-বেচার তালিকা
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                ঘোড়াশাল, চরসিন্দুর ও ডাঙ্গা এলাকার অনুমোদিত ও নির্ভরযোগ্য জমি
            </p>
        </div>

        <a href="{{ route('properties.index', ['upazila_id' => $palashUpazila?->id]) }}" class="inline-flex items-center gap-1 text-xs sm:text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
            <span>পলাশের সব জমি দেখুন ({{ $stats['palash_lands'] }})</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    @if($palashProperties->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($palashProperties as $property)
                <x-property-card :property="$property" />
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl p-8 text-center border border-slate-200">
            <p class="text-sm font-medium text-slate-500">পলাশ থানায় বর্তমানে কোনো অনুমোদিত জমি নেই।</p>
        </div>
    @endif
</section>

<!-- Interactive Land Unit Converter Section -->
<section class="bg-emerald-50/60 border-y border-emerald-100 py-12" id="calculator-section">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full uppercase tracking-wider">উপকারী টুল</span>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-2">জমির পরিমাপ কনভার্টার (Land Unit Calculator)</h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">শতাংশ, কাঠা, বিঘা, একর ও স্কয়ার ফিটের সঠিক রূপান্তর হিসাব করুন</p>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-100" x-data="landCalculator()">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <!-- Input Value -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">জমির পরিমাণ লিখুন</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        min="0"
                        x-model.number="amount" 
                        @input="convert()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-lg font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="যেমন: ৫"
                    >
                </div>

                <!-- Input Unit -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">বর্তমান একক</label>
                    <select 
                        x-model="fromUnit" 
                        @change="convert()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="decimal">শতাংশ / ডেসিমাল</option>
                        <option value="katha">কাঠা</option>
                        <option value="bigha">বিঘা</option>
                        <option value="acre">একর</option>
                        <option value="sqft">বর্গফুট (Sq Ft)</option>
                    </select>
                </div>
            </div>

            <!-- Conversion Results Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-100 text-center">
                <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="block text-[11px] font-semibold text-emerald-700">শতাংশ</span>
                    <span class="text-base sm:text-lg font-black text-emerald-950" x-text="results.decimal"></span>
                </div>
                <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="block text-[11px] font-semibold text-emerald-700">কাঠা</span>
                    <span class="text-base sm:text-lg font-black text-emerald-950" x-text="results.katha"></span>
                </div>
                <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="block text-[11px] font-semibold text-emerald-700">বিঘা</span>
                    <span class="text-base sm:text-lg font-black text-emerald-950" x-text="results.bigha"></span>
                </div>
                <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="block text-[11px] font-semibold text-emerald-700">বর্গফুট (Sq Ft)</span>
                    <span class="text-base sm:text-lg font-black text-emerald-950" x-text="results.sqft"></span>
                </div>
            </div>

            <p class="text-[11px] text-slate-400 text-center mt-3">
                * স্ট্যান্ডার্ড হিসাব: ১ শতাংশ = ৪৩৫.৬ বর্গফুট, ১ কাঠা = ১.৬৫ শতাংশ, ১ বিঘা = ৩৩ শতাংশ, ১ একর = ১০০ শতাংশ।
            </p>
        </div>
    </div>
</section>

<!-- How it Works & Trust Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center max-w-2xl mx-auto mb-12">
        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full uppercase">সহজ নিয়ম</span>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">জমিরহাটে কীভাবে জমি ক্রয়-বিক্রয় করবেন?</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-2">কোনো ঝামেলা ছাড়াই তিন ধাপে জমি বেচা-কেনার পূর্ণাঙ্গ সমাধান</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Step 1 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm relative">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 font-black text-xl flex items-center justify-center mb-4">
                ১
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-2">জমি পোস্ট করুন</h3>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                জমির মালিক বা বিক্রেতা হিসেবে সঠিক তথ্য, খতিয়ান, দাগ নম্বর, রাস্তার পরিমাপ ও ছবি দিয়ে বিনামূল্যে পোস্ট জমা দিন।
            </p>
        </div>

        <!-- Step 2 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm relative">
            <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-800 font-black text-xl flex items-center justify-center mb-4">
                ২
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-2">অ্যাডমিন রিভিউ ও অনুমোদন</h3>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                আমাদের অ্যাডমিন টিম পোস্টের তথ্য ও কাগজপত্র যাচাই করবেন। সব ঠিক থাকলে অনুমোদন (Approve) পেলেই জমিটি পাবলিক হবে।
            </p>
        </div>

        <!-- Step 3 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm relative">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 font-black text-xl flex items-center justify-center mb-4">
                ৩
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-2">সরাসরি চুক্তি ও বায়না</h3>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                আগ্রহী ক্রেতারা সরাসরি ফোনে বা WhatsApp-এ কথা বলবেন, জমি সরেজমিনে ভিজিট করবেন এবং নিরাপদে বায়না করবেন।
            </p>
        </div>
    </div>

    <!-- CTA Banner -->
    <div class="mt-12 bg-gradient-to-r from-emerald-800 to-teal-800 text-white rounded-3xl p-6 sm:p-10 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
        <div>
            <h3 class="text-xl sm:text-2xl font-black mb-1">আপনার কি পলাশ বা নরসিংদীতে জমি বিক্রির আছে?</h3>
            <p class="text-xs sm:text-sm text-emerald-100">হাজারো আগ্রহী ক্রেতার কাছে আপনার জমি পৌঁছে দিন মাত্র ২ মিনিটে।</p>
        </div>
        <a href="{{ route('properties.create') }}" class="shrink-0 bg-white text-emerald-900 hover:bg-emerald-50 font-bold px-6 py-3.5 rounded-2xl shadow-md transition active:scale-95 text-sm">
            + বিনামূল্যে জমি পোস্ট করুন
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function landCalculator() {
        return {
            amount: 5,
            fromUnit: 'decimal',
            results: {
                decimal: '5.00',
                katha: '3.03',
                bigha: '0.15',
                sqft: '2178.00'
            },
            convert() {
                let amt = parseFloat(this.amount) || 0;
                let sqft = 0;

                // Base conversion to square feet
                if (this.fromUnit === 'decimal') sqft = amt * 435.6;
                else if (this.fromUnit === 'katha') sqft = amt * 720;
                else if (this.fromUnit === 'bigha') sqft = amt * 14400;
                else if (this.fromUnit === 'acre') sqft = amt * 43560;
                else if (this.fromUnit === 'sqft') sqft = amt;

                this.results.decimal = (sqft / 435.6).toFixed(2);
                this.results.katha = (sqft / 720).toFixed(2);
                this.results.bigha = (sqft / 14400).toFixed(2);
                this.results.sqft = sqft.toFixed(2);
            }
        }
    }
</script>
@endpush

