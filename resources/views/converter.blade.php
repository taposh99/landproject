@extends('layouts.app')

@section('title', 'জমির পরিমাপ ও একক ক্যালকুলেটর - জমিরহাট')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="fullLandCalculator()">
    
    <div class="text-center max-w-2xl mx-auto mb-8">
        <span class="text-xs font-bold text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full uppercase tracking-wider">পরিমাপ টুল</span>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">বাংলাদেশের জমির হিসাব ও কনভার্টার</h1>
        <p class="text-xs sm:text-sm text-slate-600 mt-1">শতাংশ, কাঠা, বিঘা, একর ও স্কয়ার ফিটের নির্ভরযোগ্য রূপান্তর</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm mb-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">জমির পরিমাণ লিখুন</label>
                <input 
                    type="number" 
                    step="0.01" 
                    min="0"
                    x-model.number="amount" 
                    @input="calculate()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xl font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    placeholder="যেমন: ১০"
                >
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">একক নির্বাচন করুন</label>
                <select 
                    x-model="fromUnit" 
                    @change="calculate()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >
                    <option value="decimal">শতাংশ / ডেসিমাল (Decimal)</option>
                    <option value="katha">কাঠা (Katha)</option>
                    <option value="bigha">বিঘা (Bigha)</option>
                    <option value="acre">একর (Acre)</option>
                    <option value="sqft">বর্গফুট / স্কয়ার ফিট (Sq Ft)</option>
                    <option value="sqm">বর্গমিটার (Sq Metre)</option>
                </select>
            </div>
        </div>

        <!-- Calculated Results Cards -->
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">রূপান্তরিত ফলাফল:</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div class="p-4 bg-emerald-50/70 rounded-2xl border border-emerald-100 text-center">
                <span class="block text-xs font-bold text-emerald-800">শতাংশ / ডেসিমাল</span>
                <span class="text-xl sm:text-2xl font-black text-emerald-950 mt-1 block" x-text="results.decimal"></span>
            </div>

            <div class="p-4 bg-emerald-50/70 rounded-2xl border border-emerald-100 text-center">
                <span class="block text-xs font-bold text-emerald-800">কাঠা</span>
                <span class="text-xl sm:text-2xl font-black text-emerald-950 mt-1 block" x-text="results.katha"></span>
            </div>

            <div class="p-4 bg-emerald-50/70 rounded-2xl border border-emerald-100 text-center">
                <span class="block text-xs font-bold text-emerald-800">বিঘা</span>
                <span class="text-xl sm:text-2xl font-black text-emerald-950 mt-1 block" x-text="results.bigha"></span>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-center">
                <span class="block text-xs font-bold text-slate-600">একর</span>
                <span class="text-xl sm:text-2xl font-black text-slate-900 mt-1 block" x-text="results.acre"></span>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-center">
                <span class="block text-xs font-bold text-slate-600">বর্গফুট (Sq Ft)</span>
                <span class="text-xl sm:text-2xl font-black text-slate-900 mt-1 block" x-text="results.sqft"></span>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-center">
                <span class="block text-xs font-bold text-slate-600">বর্গমিটার (Sq Metre)</span>
                <span class="text-xl sm:text-2xl font-black text-slate-900 mt-1 block" x-text="results.sqm"></span>
            </div>
        </div>
    </div>

    <!-- Reference Table for Bangladesh Land Measurement -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
            <span>📖</span>
            বাংলাদেশে প্রচলিত ভূমি পরিমাপের স্ট্যান্ডার্ড চার্ট
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-700">
            <div class="space-y-2.5">
                <div class="p-3 bg-slate-50 rounded-xl flex justify-between">
                    <span>১ শতাংশ (ডেসিমাল)</span>
                    <strong class="text-slate-900">৪৩৫.৬ বর্গফুট</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl flex justify-between">
                    <span>১ কাঠা</span>
                    <strong class="text-slate-900">১.৬৫ শতাংশ (৭২০ বর্গফুট)</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl flex justify-between">
                    <span>১ বিঘা</span>
                    <strong class="text-slate-900">২০ কাঠা (৩৩ শতাংশ)</strong>
                </div>
            </div>

            <div class="space-y-2.5">
                <div class="p-3 bg-slate-50 rounded-xl flex justify-between">
                    <span>১ একর</span>
                    <strong class="text-slate-900">১০০ শতাংশ (৩ বিঘা ৮ ছটাক)</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl flex justify-between">
                    <span>১ বর্গমিটার</span>
                    <strong class="text-slate-900">১০.৭৬ বর্গফুট</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl flex justify-between">
                    <span>১ হেক্টর</span>
                    <strong class="text-slate-900">২.৪৭ একর</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function fullLandCalculator() {
        return {
            amount: 10,
            fromUnit: 'decimal',
            results: {
                decimal: '10.00',
                katha: '6.06',
                bigha: '0.30',
                acre: '0.10',
                sqft: '4356.00',
                sqm: '404.69'
            },
            init() {
                this.calculate();
            },
            calculate() {
                let amt = parseFloat(this.amount) || 0;
                let sqft = 0;

                // Base conversion to Sq Ft
                if (this.fromUnit === 'decimal') sqft = amt * 435.6;
                else if (this.fromUnit === 'katha') sqft = amt * 720;
                else if (this.fromUnit === 'bigha') sqft = amt * 14400;
                else if (this.fromUnit === 'acre') sqft = amt * 43560;
                else if (this.fromUnit === 'sqft') sqft = amt;
                else if (this.fromUnit === 'sqm') sqft = amt * 10.7639;

                this.results.decimal = (sqft / 435.6).toFixed(2);
                this.results.katha = (sqft / 720).toFixed(2);
                this.results.bigha = (sqft / 14400).toFixed(2);
                this.results.acre = (sqft / 43560).toFixed(3);
                this.results.sqft = sqft.toFixed(2);
                this.results.sqm = (sqft / 10.7639).toFixed(2);
            }
        }
    }
</script>
@endpush

