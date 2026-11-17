@extends('layouts.app')

@section('title', 'অ্যাডমিন ড্যাশবোর্ড - জমিরহাট')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ rejectModalOpen: false, rejectUrl: '', rejectTitle: '' }">
    
    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full mb-1">
                🛡️ সুপার অ্যাডমিন কন্ট্রোল প্যানেল
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900">জমির অনুমোদন ও প্ল্যাটফর্ম ড্যাশবোর্ড</h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-black text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>ইউজার ও রোল তালিকা</span>
            </a>
            <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition">
                <span>+ নতুন জমি</span>
            </a>
        </div>
    </div>

    <!-- Stats KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-amber-500 text-white rounded-3xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-amber-100 uppercase tracking-wider">অপেক্ষমান পোস্ট</span>
                <span class="p-2 bg-amber-400/50 rounded-xl">⏳</span>
            </div>
            <p class="text-3xl font-black mt-2">{{ $stats['pending'] }}</p>
            <p class="text-[11px] text-amber-100 mt-1">পর্যালোচনা ও অনুমোদনের অপেক্ষায়</p>
        </div>

        <div class="bg-emerald-600 text-white rounded-3xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-100 uppercase tracking-wider">অনুমোদিত জমি</span>
                <span class="p-2 bg-emerald-500/50 rounded-xl">✓</span>
            </div>
            <p class="text-3xl font-black mt-2">{{ $stats['approved'] }}</p>
            <p class="text-[11px] text-emerald-100 mt-1">পাবলিকলি দৃশ্যমান ও লাইভ</p>
        </div>

        <div class="bg-slate-800 text-white rounded-3xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">বিক্রিত (Sold)</span>
                <span class="p-2 bg-slate-700 rounded-xl">🤝</span>
            </div>
            <p class="text-3xl font-black mt-2">{{ $stats['sold'] }}</p>
            <p class="text-[11px] text-slate-300 mt-1">সফলভাবে বিক্রি সম্পন্ন</p>
        </div>

        <div class="bg-teal-700 text-white rounded-3xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-teal-200 uppercase tracking-wider">মোট নিবন্ধিত ইউজার</span>
                <span class="p-2 bg-teal-600/50 rounded-xl">👥</span>
            </div>
            <p class="text-3xl font-black mt-2">{{ $stats['users'] }}</p>
            <p class="text-[11px] text-teal-200 mt-1">ক্রেতা ও বিক্রেতা</p>
        </div>
    </div>

    <!-- Section 1: PENDING APPROVAL QUEUE (Most Critical Feature) -->
    <div class="bg-white rounded-3xl p-6 border-2 border-amber-200 shadow-md mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-500 animate-ping"></span>
                    অপেক্ষমান জমির অনুমোদন কিউ (Pending Approvals Queue)
                </h2>
                <p class="text-xs text-slate-500">ইউজারদের পোস্ট করা নতুন জমিগুলো রিভিউ করে অনুমোদন (Approve) অথবা বাতিল (Reject) করুন</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-900">
                {{ $pendingProperties->count() }} টি অপেক্ষমান
            </span>
        </div>

        @if($pendingProperties->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 uppercase font-black tracking-wider text-[11px] border-y border-slate-200">
                        <tr>
                            <th class="py-3 px-4">জমি / শিরোনাম</th>
                            <th class="py-3 px-4">পোস্টকারী</th>
                            <th class="py-3 px-4">অবস্থান</th>
                            <th class="py-3 px-4">পরিমাপ ও মূল্য</th>
                            <th class="py-3 px-4">কাগজপত্র</th>
                            <th class="py-3 px-4 text-right">অ্যাকশন (সিদ্ধান্ত)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($pendingProperties as $property)
                            <tr class="hover:bg-amber-50/40 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $property->featured_image }}" class="w-12 h-12 rounded-xl object-cover shrink-0 bg-slate-100">
                                        <div>
                                            <p class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-1">{{ $property->title }}</p>
                                            <span class="text-[10px] text-slate-400">জমা: {{ $property->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-slate-800">{{ $property->user?->name ?? 'Unknown' }}</p>
                                    <p class="text-[11px] text-slate-500">📞 {{ $property->contact_number }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-semibold text-emerald-800">{{ $property->upazila?->bn_name }}</span>
                                    <p class="text-[11px] text-slate-500">{{ $property->mouza_area ?? 'নরসিংদী' }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-slate-800">{{ $property->land_size }} {{ $property->size_unit_bangla }}</span>
                                    <p class="text-xs font-black text-emerald-700">৳ {{ $property->formatted_price }}</p>
                                </td>
                                <td class="py-3.5 px-4 text-[11px]">
                                    <p>খতিয়ান: <strong>{{ $property->khatian_type ?? 'N/A' }}</strong></p>
                                    <p>খারিজ: <strong>{{ $property->is_mutation_done ? '✓ আছে' : '✗ নেই' }}</strong></p>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Approve Button -->
                                        <form action="{{ route('admin.properties.approve', $property->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1.5 px-3 rounded-xl text-xs shadow-sm transition flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <span>অনুমোদন দিন</span>
                                            </button>
                                        </form>

                                        <!-- Reject Button -->
                                        <button 
                                            type="button" 
                                            @click="rejectUrl = '{{ route('admin.properties.reject', $property->id) }}'; rejectTitle = '{{ addslashes($property->title) }}'; rejectModalOpen = true"
                                            class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold py-1.5 px-3 rounded-xl text-xs transition"
                                        >
                                            বাতিল
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-slate-400 text-xs">
                🎉 বর্তমানে কোনো অপেক্ষমান পোস্ট নেই! সব লিস্টিং রিভিউ করা হয়েছে।
            </div>
        @endif
    </div>

    <!-- Section 2: APPROVED & ALL PROPERTIES MANAGEMENT -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
        <h2 class="text-lg font-black text-slate-900 mb-4">সকল অনুমোদিত জমির তালিকা</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-black tracking-wider text-[11px] border-y border-slate-200">
                    <tr>
                        <th class="py-3 px-4">জমি</th>
                        <th class="py-3 px-4">অবস্থান</th>
                        <th class="py-3 px-4">মূল্য</th>
                        <th class="py-3 px-4">ব্যাজ ও স্ট্যাটাস</th>
                        <th class="py-3 px-4 text-right">ম্যানেজ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($approvedProperties as $property)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4">
                                <a href="{{ route('properties.show', $property->slug) }}" class="font-bold text-slate-900 hover:text-emerald-700 text-xs sm:text-sm line-clamp-1">
                                    {{ $property->title }}
                                </a>
                                <span class="text-[10px] text-slate-400">মালিক: {{ $property->user?->name }} • 👁️ {{ $property->views_count }} ভিউ</span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $property->upazila?->bn_name }}
                            </td>
                            <td class="py-3 px-4 font-black text-emerald-800">
                                ৳ {{ $property->formatted_price }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1.5">
                                    @if($property->is_verified)
                                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-lg">ভেরিফাইড</span>
                                    @endif
                                    @if($property->is_featured)
                                        <span class="bg-amber-100 text-amber-900 text-[10px] font-bold px-2 py-0.5 rounded-lg">ফিচার্ড</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Toggle Verified Badge -->
                                    <form action="{{ route('admin.properties.toggle-verify', $property->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 text-[11px] font-bold rounded-lg border {{ $property->is_verified ? 'border-amber-300 text-amber-800 hover:bg-amber-50' : 'border-emerald-300 text-emerald-700 hover:bg-emerald-50' }}" title="ভেরিফাইড টগল">
                                            {{ $property->is_verified ? 'ব্যাজ মুছুন' : '+ ভেরিফাই' }}
                                        </button>
                                    </form>

                                    <!-- Delete Property -->
                                    <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে জমিটি স্থায়ীভাবে মুছে ফেলতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg" title="মুছে ফেলুন">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $approvedProperties->links() }}
        </div>
    </div>

    <!-- Reject Modal -->
    <div x-show="rejectModalOpen" x-transition class="fixed inset-0 z-50 bg-black/50 p-4 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-xl" @click.outside="rejectModalOpen = false">
            <h3 class="text-base font-bold text-slate-900 mb-1">পোস্ট বাতিলের কারণ</h3>
            <p class="text-xs text-slate-500 mb-4" x-text="rejectTitle"></p>

            <form :action="rejectUrl" method="POST">
                @csrf
                <textarea 
                    name="rejection_reason" 
                    rows="3" 
                    required 
                    placeholder="বাতিলের কারণ লিখুন (যেমন: কাগজপত্রে সমস্যা, অবাস্তব দাম, ইত্যাদি)..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-medium focus:ring-2 focus:ring-rose-500 focus:outline-none mb-4"
                ></textarea>

                <div class="flex items-center justify-end gap-2">
                    <button type="button" @click="rejectModalOpen = false" class="px-4 py-2 text-xs font-bold text-slate-600 bg-slate-100 rounded-xl">
                        বাতিল করুন
                    </button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl">
                        পোস্ট রিজেক্ট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

