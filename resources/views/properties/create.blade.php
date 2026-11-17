@extends('layouts.app')

@section('title', 'নতুন জমি পোস্ট করুন - জমিরহাট')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">নতুন জমি বিক্রির বিজ্ঞাপন দিন</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            সঠিক তথ্য দিয়ে ফর্মটি পূরণ করুন। আপনার সাবমিট করা পোস্টটি অ্যাডমিন রিভিউ করে অ্যাপ্রুভ করবেন।
        </p>
    </div>

    <!-- Alert Note on Admin Approval -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6 flex items-start gap-3">
        <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="text-xs text-amber-900 leading-relaxed">
            <strong>অনুমোদন প্রক্রিয়া:</strong> নিরাপত্তার স্বার্থে পোস্ট করার সাথে সাথে জমিটি সরাসরি লাইভ হবে না। অ্যাডমিন প্যানেল থেকে তথ্য যাচাই করে <strong>অনুমোদন (Approve)</strong> দেওয়ার পর এটি জনসমক্ষে প্রদর্শিত হবে।
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-900 text-xs p-4 rounded-2xl mb-6">
            <p class="font-bold mb-1">ফর্ম পূরণে কিছু ত্রুটি রয়েছে:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- 1. Basic Info -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 text-xs flex items-center justify-center font-bold">১</span>
                জমির শিরোনাম ও অবস্থান
            </h2>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">বিজ্ঞাপনের শিরোনাম *</label>
                <input 
                    type="text" 
                    name="title" 
                    required 
                    value="{{ old('title') }}" 
                    placeholder="যেমন: পলাশ ঘোড়াশাল মেইন রোডের পাশে ৫ শতাংশ আবাসিক প্লট"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">জেলা *</label>
                    <select name="district_id" id="post_district_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ $district->name === 'Narsingdi' ? 'selected' : '' }}>
                                {{ $district->bn_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">উপজেলা / থানা *</label>
                    <select name="upazila_id" id="post_upazila_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @foreach($districts->firstWhere('name', 'Narsingdi')?->upazilas ?? [] as $upz)
                            <option value="{{ $upz->id }}" {{ $upz->name === 'Palash' ? 'selected' : '' }}>
                                {{ $upz->bn_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">মৌজা বা ইউনিয়ন / এলাকার নাম</label>
                    <input 
                        type="text" 
                        name="mouza_area" 
                        value="{{ old('mouza_area') }}" 
                        placeholder="যেমন: ঘোড়াশাল পৌরসভা / চরসিন্দুর / ডাঙ্গা"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">সুনির্দিষ্ট ঠিকানা / ল্যান্ডমার্ক</label>
                    <input 
                        type="text" 
                        name="address" 
                        value="{{ old('address') }}" 
                        placeholder="যেমন: বাসস্ট্যান্ড সংলগ্ন, ঘোড়াশাল"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>
            </div>
        </div>

        <!-- 2. Land Size, Price & Type -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 text-xs flex items-center justify-center font-bold">২</span>
                জমির ধরন, মাপ ও দামের বিবরণ
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">জমির ধরন *</label>
                    <select name="land_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="residential">🏡 আবাসিক জমি / প্লট</option>
                        <option value="commercial">🏬 বাণিজ্যিক জমি / দোকান</option>
                        <option value="agricultural">🌾 কৃষি / নাল জমি</option>
                        <option value="industrial">🏭 শিল্প কারখানার জমি</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">জমির পরিমাণ *</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="land_size" 
                        required 
                        value="{{ old('land_size', '5') }}" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">একক *</label>
                    <select name="size_unit" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="decimal">শতাংশ / ডেসিমাল</option>
                        <option value="katha">কাঠা</option>
                        <option value="bigha">বিঘা</option>
                        <option value="acre">একর</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">মোট দাম (টাকায়) *</label>
                    <input 
                        type="number" 
                        name="price" 
                        required 
                        value="{{ old('price') }}" 
                        placeholder="যেমন: 3500000 (৩৫ লাখ)"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">দামের ধরন *</label>
                    <select name="price_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="total">সম্পূর্ণ জমির মোট দাম</option>
                        <option value="per_decimal">প্রতি শতাংশের দাম</option>
                        <option value="per_katha">প্রতি কাঠার দাম</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    id="is_negotiable" 
                    name="is_negotiable" 
                    value="1" 
                    {{ old('is_negotiable', true) ? 'checked' : '' }}
                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                >
                <label for="is_negotiable" class="text-xs font-bold text-slate-700 cursor-pointer">দাম আলোচনা সাপেক্ষ</label>
            </div>
        </div>

        <!-- 3. Road & Legal status -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 text-xs flex items-center justify-center font-bold">৩</span>
                রাস্তা ও আইনি কাগজপত্র
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">সামনের রাস্তার প্রশস্ততা (ফিট)</label>
                    <input 
                        type="number" 
                        name="road_width_feet" 
                        value="{{ old('road_width_feet', '16') }}" 
                        placeholder="যেমন: ১৬"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">রাস্তার ধরন</label>
                    <select name="road_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="paved">পাকা / পিচ ঢালাই রাস্তা</option>
                        <option value="brick">ইটের সোলিং রাস্তা</option>
                        <option value="dirt">কাঁচা রাস্তা</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">খতিয়ান টাইপ</label>
                    <input 
                        type="text" 
                        name="khatian_type" 
                        value="{{ old('khatian_type', 'RS / BS') }}" 
                        placeholder="যেমন: RS, BS"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">দাগ নম্বর (ঐচ্ছিক)</label>
                    <input 
                        type="text" 
                        name="daag_no" 
                        value="{{ old('daag_no') }}" 
                        placeholder="দাগ নং"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">খতিয়ান নম্বর (ঐচ্ছিক)</label>
                    <input 
                        type="text" 
                        name="khatian_no" 
                        value="{{ old('khatian_no') }}" 
                        placeholder="খতিয়ান নং"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <input 
                        type="checkbox" 
                        name="is_mutation_done" 
                        value="1" 
                        {{ old('is_mutation_done') ? 'checked' : '' }}
                        class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                    >
                    <span class="text-xs font-bold text-slate-800">নামজারি / খারিজ সম্পন্ন হয়েছে</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <input 
                        type="checkbox" 
                        name="is_tax_updated" 
                        value="1" 
                        {{ old('is_tax_updated') ? 'checked' : '' }}
                        class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                    >
                    <span class="text-xs font-bold text-slate-800">খাজনা হালনাগাদ পরিশোধিত আছে</span>
                </label>
            </div>
        </div>

        <!-- 4. Media & Contact -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 text-xs flex items-center justify-center font-bold">৪</span>
                ছবি ও যোগাযোগের তথ্য
            </h2>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">জমির ছবি (আপলোড অথবা ইমেজ লিংক)</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input 
                        type="file" 
                        name="image_file" 
                        accept="image/*"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 bg-slate-50 rounded-xl p-2 border border-slate-200"
                    >
                    <input 
                        type="url" 
                        name="featured_image" 
                        value="{{ old('featured_image') }}" 
                        placeholder="অথবা ইমেজের অনলাইন URL"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">সরাসরি যোগাযোগের মোবাইল নম্বর *</label>
                    <input 
                        type="tel" 
                        name="contact_number" 
                        required 
                        value="{{ old('contact_number', Auth::user()->phone) }}" 
                        placeholder="01XXXXXXXXX"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">WhatsApp নম্বর (মেসেজ পাওয়ার জন্য)</label>
                    <input 
                        type="tel" 
                        name="whatsapp_number" 
                        value="{{ old('whatsapp_number', Auth::user()->phone) }}" 
                        placeholder="01XXXXXXXXX"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">জমির বিস্তারিত বিবরণ *</label>
                <textarea 
                    name="description" 
                    rows="4" 
                    required 
                    placeholder="জমির আশেপাশের পরিবেশ, গ্যাস-বিদ্যুৎ সুবিধা, বাউন্ডারি আছে কি না, ইত্যাদি বিস্তারিত লিখুন..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                >{{ old('description') }}</textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 px-6 rounded-2xl shadow-lg shadow-emerald-600/20 transition active:scale-95 text-base flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
                <span>জমি পোস্ট জমা দিন (অ্যাডমিন পর্যালোচনার জন্য)</span>
            </button>
        </div>
    </form>
</div>
@endsection

