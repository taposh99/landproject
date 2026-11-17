@extends('layouts.app')

@section('title', 'আমার জমিসমূহ - জমিরহাট')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900">আমার পোস্ট করা জমিসমূহ</h1>
            <p class="text-xs sm:text-sm text-slate-500">আপনার পোস্ট করা সকল জমির বর্তমান অবস্থা (Status) ও ম্যানেজমেন্ট</p>
        </div>

        <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-2xl shadow-sm transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>নতুন জমি পোস্ট করুন</span>
        </a>
    </div>

    @if($properties->count() > 0)
        <div class="space-y-4">
            @foreach($properties as $property)
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    
                    <!-- Left: Image & Info -->
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <img 
                            src="{{ $property->featured_image ?? 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=400&q=80' }}" 
                            alt="{{ $property->title }}" 
                            class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover shrink-0 bg-slate-100"
                        >
                        <div>
                            <!-- Status Badges -->
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                @if($property->status === 'approved')
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        অনুমোদিত (পাবলিকলি লাইভ)
                                    </span>
                                @elseif($property->status === 'pending')
                                    <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-900 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                                        অ্যাডমিন অনুমোদনের অপেক্ষায়
                                    </span>
                                @elseif($property->status === 'rejected')
                                    <span class="inline-flex items-center gap-1 bg-rose-100 text-rose-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                        বাতিল করা হয়েছে
                                    </span>
                                @elseif($property->status === 'sold')
                                    <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-700 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                        বিক্রিত (SOLD)
                                    </span>
                                @endif

                                @if($property->is_verified)
                                    <span class="bg-teal-50 text-teal-800 text-[10px] font-bold px-2 py-0.5 rounded-lg border border-teal-200">
                                        ✓ ভেরিফাইড
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug line-clamp-1">
                                {{ $property->title }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                📍 {{ $property->mouza_area ? $property->mouza_area . ', ' : '' }}{{ $property->upazila?->bn_name }} • 
                                📏 {{ $property->land_size }} {{ $property->size_unit_bangla }} • 
                                ৳ {{ $property->formatted_price }}
                            </p>

                            @if($property->status === 'rejected' && $property->rejection_reason)
                                <p class="text-xs text-rose-600 bg-rose-50 p-2 rounded-xl mt-2">
                                    <strong>বাতিলের কারণ:</strong> {{ $property->rejection_reason }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-2 w-full md:w-auto justify-end pt-2 md:pt-0 border-t md:border-0 border-slate-100">
                        @if($property->status === 'approved')
                            <a href="{{ route('properties.show', $property->slug) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold px-3 py-2 rounded-xl transition">
                                পাবলিক ভিউ দেখুন
                            </a>

                            <form action="{{ route('properties.sold', $property->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে জমিটি বিক্রি হয়ে গেছে?');">
                                @csrf
                                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-3 py-2 rounded-xl transition">
                                    Sold মার্ক করুন
                                </button>
                            </form>
                        @elseif($property->status === 'pending')
                            <span class="text-xs text-amber-700 bg-amber-50 px-3 py-1.5 rounded-xl font-medium">
                                অ্যাডমিন যাচাই করছেন...
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="mt-6">
                {{ $properties->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-2">আপনি এখনও কোনো জমি পোস্ট করেননি</h3>
            <p class="text-xs text-slate-500 mb-6">আপনার কোনো জমি বিক্রির থাকলে এখনই বিজ্ঞাপন পোস্ট করুন।</p>
            <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white text-xs font-bold px-5 py-2.5 rounded-2xl shadow-sm">
                + জমি পোস্ট করুন
            </a>
        </div>
    @endif
</div>
@endsection

