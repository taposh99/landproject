@extends('layouts.app')

@section('title', $property->title . ' - জমিরহাট')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-slate-500 mb-4 overflow-x-auto pb-1 no-scrollbar">
        <a href="{{ route('home') }}" class="hover:text-emerald-700 shrink-0">হোম</a>
        <span>/</span>
        <a href="{{ route('properties.index') }}" class="hover:text-emerald-700 shrink-0">জমির তালিকা</a>
        <span>/</span>
        <a href="{{ route('properties.index', ['upazila_id' => $property->upazila_id]) }}" class="hover:text-emerald-700 shrink-0 text-emerald-700 font-semibold">
            {{ $property->upazila?->bn_name ?? 'পলাশ' }}
        </a>
        @if($property->union)
            <span>/</span>
            <a href="{{ route('properties.index', ['upazila_id' => $property->upazila_id, 'union_id' => $property->union_id]) }}" class="hover:text-emerald-700 shrink-0 font-medium">
                {{ $property->union->bn_name }}
            </a>
        @endif
        @if($property->village)
            <span>/</span>
            <span class="text-slate-600 shrink-0 font-semibold">
                {{ $property->village->bn_name }}
            </span>
        @endif
        <span>/</span>
        <span class="text-slate-800 font-semibold truncate">{{ $property->title }}</span>
    </nav>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Media & Land Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Featured Image -->
            <div class="relative aspect-[16/10] sm:aspect-[16/9] rounded-3xl overflow-hidden bg-slate-100 shadow-sm border border-slate-200">
                <img 
                    src="{{ $property->featured_image ?? 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80' }}" 
                    alt="{{ $property->title }}" 
                    class="w-full h-full object-cover"
                >

                <!-- Badges -->
                <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                    @if($property->is_verified)
                        <span class="inline-flex items-center gap-1.5 bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-xl shadow-md">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            ১০০% ভেরিফাইড জমি
                        </span>
                    @endif

                    <span class="bg-slate-900/90 text-white text-xs font-semibold px-3 py-1 rounded-xl backdrop-blur">
                        {{ $property->land_type_bangla }}
                    </span>
                </div>

                @if($property->status === 'sold')
                    <div class="absolute inset-0 bg-slate-950/75 backdrop-blur-xs flex items-center justify-center">
                        <span class="bg-rose-600 text-white font-black text-xl tracking-wider uppercase px-6 py-2 rounded-2xl shadow-xl">
                            জমিটি বিক্রি হয়ে গেছে (SOLD)
                        </span>
                    </div>
                @endif
            </div>

            <!-- Title & Price Block -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-4 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-1">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $property->address ?? (($property->village ? $property->village->bn_name . ', ' : '') . ($property->union ? $property->union->bn_name . ', ' : '') . $property->upazila?->bn_name . ', ' . $property->district?->bn_name) }}</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">
                            {{ $property->title }}
                        </h1>
                    </div>

                    <!-- Price -->
                    <div class="sm:text-right shrink-0 bg-emerald-50/80 p-3 sm:p-0 sm:bg-transparent rounded-2xl">
                        <p class="text-xs text-slate-500 font-bold">মোট মূল্য</p>
                        <p class="text-2xl sm:text-3xl font-black text-emerald-800">
                            ৳ {{ $property->formatted_price }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ $property->is_negotiable ? 'আলোচনা সাপেক্ষ' : 'ফিক্সড রেট' }}
                        </p>
                    </div>
                </div>

                <!-- Key Specs Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-4 border-b border-slate-100">
                    <div class="bg-slate-50 p-3 rounded-2xl">
                        <span class="block text-[11px] text-slate-500 font-medium">জমির পরিমাপ</span>
                        <span class="text-sm sm:text-base font-black text-slate-900">{{ $property->land_size }} {{ $property->size_unit_bangla }}</span>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-2xl">
                        <span class="block text-[11px] text-slate-500 font-medium">সামনের রাস্তা</span>
                        <span class="text-sm sm:text-base font-black text-slate-900">
                            {{ $property->road_width_feet ? $property->road_width_feet . ' ফিট' : 'রাস্তা আছে' }}
                            @if($property->road_type)
                                <span class="text-xs font-normal text-slate-500">({{ $property->road_type === 'paved' ? 'পাকা' : ($property->road_type === 'brick' ? 'ইটের সোলিং' : 'কাঁচা') }})</span>
                            @endif
                        </span>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-2xl">
                        <span class="block text-[11px] text-slate-500 font-medium">ইউনিয়ন / পৌরসভা</span>
                        <span class="text-sm sm:text-base font-black text-emerald-800">{{ $property->union?->bn_name ?? $property->upazila?->bn_name }}</span>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-2xl">
                        <span class="block text-[11px] text-slate-500 font-medium">গ্রাম / এলাকা</span>
                        <span class="text-sm sm:text-base font-black text-slate-900">{{ $property->village?->bn_name ?? ($property->mouza_area ?? 'পলাশ') }}</span>
                    </div>
                </div>

                <!-- Legal Paperwork Status Table -->
                <div class="py-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">কাগজপত্র ও আইনি তথ্যাদি</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-500">খতিয়ান টাইপ:</span>
                            <span class="font-bold text-slate-800">{{ $property->khatian_type ?? 'RS / BS' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-500">দাগ নম্বর:</span>
                            <span class="font-bold text-slate-800">{{ $property->daag_no ?? 'মালিকের কাছে সংরক্ষিত' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-500">নামজারি / খারিজ:</span>
                            @if($property->is_mutation_done)
                                <span class="text-emerald-700 font-bold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    সম্পন্ন হয়েছে
                                </span>
                            @else
                                <span class="text-amber-600 font-semibold">প্রক্রিয়াধীন / করা যাবে</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-500">খাজনা স্ট্যাটাস:</span>
                            @if($property->is_tax_updated)
                                <span class="text-emerald-700 font-bold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    হালনাগাদ পরিশোধিত
                                </span>
                            @else
                                <span class="text-slate-600 font-medium">হালনাগাদ প্রয়োজন</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">জমির বিস্তারিত বিবরণ</h3>
                    <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $property->description }}
                    </div>
                </div>
            </div>

            <!-- YouTube Video Player Section -->
            @if($property->youtube_embed_url)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-black text-slate-900 text-sm sm:text-base flex items-center gap-2">
                            <span class="p-1.5 rounded-lg bg-red-50 text-red-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </span>
                            <span>জমির সরজমিন ভিডিও (Land Video Tour)</span>
                        </h3>
                        <span class="text-[11px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-md">YouTube</span>
                    </div>

                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-black shadow-md">
                        <iframe 
                            src="{{ $property->youtube_embed_url }}" 
                            title="YouTube video player" 
                            class="w-full h-full border-0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen
                        ></iframe>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-2 flex items-center gap-1.5">
                        <span>💡</span>
                        <span>জমির অবস্থান, রাস্তা ও চারপাশের পরিবেশ বাস্তব ভিডিও থেকে দেখে নিন।</span>
                    </p>
                </div>
            @endif

            <!-- Pre-calculated Unit Converter for this land -->
            <div class="bg-emerald-50 rounded-3xl p-5 border border-emerald-100">
                <h3 class="font-bold text-emerald-950 text-sm mb-1">
                    📐 এই জমিটির মাপ বিভিন্ন এককে:
                </h3>
                @php
                    $landSize = (float) $property->land_size;
                    $unit = $property->size_unit;
                    // convert to decimal first
                    $decimals = match($unit) {
                        'katha' => $landSize * 1.65,
                        'bigha' => $landSize * 33.0,
                        'acre' => $landSize * 100.0,
                        default => $landSize,
                    };
                    $sqft = $decimals * 435.6;
                    $katha = $decimals / 1.65;
                    $bigha = $decimals / 33.0;
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-3 text-center text-xs">
                    <div class="bg-white p-2.5 rounded-xl border border-emerald-100">
                        <span class="text-slate-500 text-[10px] block">শতাংশ</span>
                        <span class="font-black text-emerald-900 text-sm">{{ number_format($decimals, 2) }}</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-xl border border-emerald-100">
                        <span class="text-slate-500 text-[10px] block">কাঠা</span>
                        <span class="font-black text-emerald-900 text-sm">{{ number_format($katha, 2) }}</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-xl border border-emerald-100">
                        <span class="text-slate-500 text-[10px] block">বিঘা</span>
                        <span class="font-black text-emerald-900 text-sm">{{ number_format($bigha, 2) }}</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-xl border border-emerald-100">
                        <span class="text-slate-500 text-[10px] block">বর্গফুট</span>
                        <span class="font-black text-emerald-900 text-sm">{{ number_format($sqft, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Col: Contact, Owner Info, Book Visit Form -->
        <div class="space-y-6">
            
            <!-- Seller Contact Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm sticky top-20">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 font-black text-lg flex items-center justify-center shrink-0">
                        {{ mb_substr($property->user?->name ?? 'জ', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $property->user?->name ?? 'জমির মালিক' }}</h4>
                        <p class="text-xs text-slate-500">বিজ্ঞাপনদাতা (জমির মালিক/প্রতিনিধি)</p>
                        <p class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            সরাসরি কথা বলুন
                        </p>
                    </div>
                </div>

                <!-- Call & WhatsApp CTA -->
                <div class="py-4 space-y-2.5">
                    <a href="tel:{{ $property->contact_number }}" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-2xl shadow-md transition active:scale-95 text-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>সরাসরি কল করুন ({{ $property->contact_number }})</span>
                    </a>

                    @if($property->whatsapp_number)
                        <a href="https://wa.me/88{{ $property->whatsapp_number }}?text={{ urlencode('আসসালামু আলাইকুম, আমি জমিরহাট প্ল্যাটফর্মে আপনার ' . $property->title . ' জমিটি দেখেছি। এই বিষয়ে বিস্তারিত জানতে চাই।') }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold py-3 px-4 rounded-2xl transition active:scale-95 text-sm">
                            <svg class="w-5 h-5 fill-emerald-600" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                            </svg>
                            <span>WhatsApp এ মেসেজ দিন</span>
                        </a>
                    @endif
                </div>

                <!-- Book a Site Visit Form -->
                <div class="pt-4 border-t border-slate-100">
                    <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-2">
                        🗓️ জমি পরিদর্শনের আবেদন (Book a Visit)
                    </h4>
                    <p class="text-xs text-slate-500 mb-3">জমিতে সরেজমিনে যেতে চাইলে সময় ও আপনার তথ্য দিন:</p>

                    <form action="{{ route('properties.inquiry', $property->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <input 
                                type="text" 
                                name="name" 
                                required 
                                value="{{ Auth::user()?->name ?? '' }}" 
                                placeholder="আপনার নাম"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                            >
                        </div>
                        <div>
                            <input 
                                type="tel" 
                                name="phone" 
                                required 
                                value="{{ Auth::user()?->phone ?? '' }}" 
                                placeholder="মোবাইল নম্বর"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                            >
                        </div>
                        <div>
                            <label class="block text-[11px] text-slate-500 font-semibold mb-1">পরিদর্শনের সম্ভাব্য তারিখ:</label>
                            <input 
                                type="date" 
                                name="preferred_visit_date" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                            >
                        </div>
                        <div>
                            <textarea 
                                name="message" 
                                rows="2" 
                                required 
                                placeholder="আপনার বার্তা বা প্রশ্ন..."
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                            >আমি জমিটি দেখতে আগ্রহী।</textarea>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow-sm transition">
                            আবেদন পাঠান
                        </button>
                    </form>
                </div>

                <!-- Safety Note -->
                <div class="mt-4 p-3 bg-amber-50 rounded-2xl border border-amber-200 text-[11px] text-amber-900 leading-snug">
                    ⚠️ <strong>সতর্কতা:</strong> জমি রেজিস্ট্রি ও সঠিক পর্চা/খতিয়ান যাচাই ছাড়া কোনো প্রকার অগ্রিম অর্থ লেনদেন করবেন না।
                </div>
            </div>
        </div>
    </div>

    <!-- Related Lands in Palash -->
    @if($relatedProperties->count() > 0)
        <div class="mt-16 pt-8 border-t border-slate-200">
            <h2 class="text-xl font-black text-slate-900 mb-6">
                {{ $property->upazila?->bn_name ?? 'পলাশ' }} এলাকার অন্যান্য জমি
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedProperties as $related)
                    <x-property-card :property="$related" />
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

