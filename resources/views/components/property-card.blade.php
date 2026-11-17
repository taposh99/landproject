@props(['property'])

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col group">
    <!-- Image & Badges -->
    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
        <img 
            src="{{ $property->featured_image ?? 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80' }}" 
            alt="{{ $property->title }}" 
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            loading="lazy"
        >

        <!-- Top Badges -->
        <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1.5 items-center">
            @if($property->is_verified)
                <span class="inline-flex items-center gap-1 bg-emerald-600/95 backdrop-blur text-white text-[11px] font-bold px-2 py-0.5 rounded-lg shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    ভেরিফাইড
                </span>
            @endif

            <span class="inline-flex items-center bg-slate-900/80 backdrop-blur text-white text-[11px] font-medium px-2 py-0.5 rounded-lg">
                {{ $property->land_type_bangla }}
            </span>
        </div>

        <!-- Sold or Status Overlay -->
        @if($property->status === 'sold')
            <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center">
                <span class="bg-rose-600 text-white font-bold text-sm tracking-wider uppercase px-4 py-1.5 rounded-xl shadow-lg rotate-[-5deg]">
                    বিক্রিত (SOLD)
                </span>
            </div>
        @endif

        <!-- Price pill -->
        <div class="absolute bottom-2.5 left-2.5 bg-white/95 backdrop-blur px-2.5 py-1 rounded-xl shadow-sm border border-slate-100">
            <span class="text-sm font-extrabold text-emerald-800">
                ৳ {{ $property->formatted_price }}
            </span>
            @if($property->is_negotiable)
                <span class="text-[10px] text-slate-500 font-medium">(আলোচনা সাপেক্ষ)</span>
            @endif
        </div>
    </div>

    <!-- Content -->
    <div class="p-4 flex flex-col flex-grow">
        <!-- Location -->
        <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-1.5">
            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="truncate font-medium">
                {{ $property->mouza_area ? $property->mouza_area . ', ' : '' }}
                {{ $property->upazila?->bn_name ?? 'পলাশ' }}, 
                {{ $property->district?->bn_name ?? 'নরসিংদী' }}
            </span>
        </div>

        <!-- Title -->
        <a href="{{ route('properties.show', $property->slug) }}" class="group-hover:text-emerald-700 transition">
            <h3 class="font-bold text-slate-900 text-sm sm:text-base line-clamp-2 leading-snug mb-3">
                {{ $property->title }}
            </h3>
        </a>

        <!-- Specs Pills Grid -->
        <div class="grid grid-cols-2 gap-2 text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100 mt-auto mb-3">
            <div class="flex items-center gap-1.5">
                <span class="text-slate-400">📏 মাপ:</span>
                <span class="font-bold text-slate-800">{{ $property->land_size }} {{ $property->size_unit_bangla }}</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="text-slate-400">🛣️ রাস্তা:</span>
                <span class="font-semibold text-slate-800">
                    {{ $property->road_width_feet ? $property->road_width_feet . ' ফিট' : 'রাস্তা আছে' }}
                </span>
            </div>
            @if($property->is_mutation_done)
                <div class="col-span-2 text-[11px] text-emerald-700 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    নামজারি/খারিজ ও খাজনা হালনাগাদ
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-2 pt-1 border-t border-slate-100">
            <a href="{{ route('properties.show', $property->slug) }}" class="flex-grow text-center bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold py-2 px-3 rounded-xl transition">
                বিস্তারিত দেখুন
            </a>

            @if($property->whatsapp_number)
                <a href="https://wa.me/88{{ $property->whatsapp_number }}?text={{ urlencode('আসসালামু আলাইকুম, আমি জমিরহাট সাইটে আপনার ' . $property->title . ' জমিটি দেখেছি। এই বিষয়ে বিস্তারিত জানতে চাই।') }}" target="_blank" rel="noopener noreferrer" class="shrink-0 p-2 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition" title="WhatsApp এ মেসেজ দিন">
                    <!-- WhatsApp Icon -->
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                </a>
            @endif

            <a href="tel:{{ $property->contact_number }}" class="shrink-0 p-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition" title="কল করুন">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </a>
        </div>
    </div>
</div>

