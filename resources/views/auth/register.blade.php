@extends('layouts.app')

@section('title', 'রেজিস্ট্রেশন - জমিরহাট')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="text-center mb-6">
            <h1 class="text-xl font-black text-slate-900">নতুন অ্যাকাউন্ট তৈরি করুন</h1>
            <p class="text-xs text-slate-500 mt-1">পলাশ ও নরসিংদীর বিশ্বস্ত জমি কেনা-বেচার প্ল্যাটফর্মে যুক্ত হোন</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs p-3.5 rounded-2xl mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Role Selector -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">আপনি কী হিসেবে যুক্ত হতে চান? *</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                        <input type="radio" name="role" value="seller" checked class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs font-bold text-slate-900">🏡 জমির মালিক</span>
                            <span class="block text-[10px] text-slate-500">জমি বিক্রি করতে চাই</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                        <input type="radio" name="role" value="buyer" class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs font-bold text-slate-900">👤 ক্রেতা</span>
                            <span class="block text-[10px] text-slate-500">জমি কিনতে চাই</span>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">পূর্ণ নাম *</label>
                <input 
                    type="text" 
                    name="name" 
                    required 
                    value="{{ old('name') }}" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    placeholder="আপনার পুরো নাম"
                >
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">ইমেইল ঠিকানা *</label>
                <input 
                    type="email" 
                    name="email" 
                    required 
                    value="{{ old('email') }}" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    placeholder="example@mail.com"
                >
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">মোবাইল নম্বর *</label>
                <input 
                    type="tel" 
                    name="phone" 
                    required 
                    value="{{ old('phone') }}" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    placeholder="01XXXXXXXXX"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">পাসওয়ার্ড *</label>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        placeholder="কমপক্ষে ৬ অক্ষর"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">পাসওয়ার্ড নিশ্চিত করুন *</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        placeholder="পুনরায় পাসওয়ার্ড"
                    >
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-3 px-4 rounded-xl text-sm shadow-md transition active:scale-95">
                অ্যাকাউন্ট তৈরি করুন
            </button>
        </form>

        <p class="text-center text-xs text-slate-500 mt-6">
            ইতিমধ্যে অ্যাকাউন্ট আছে? 
            <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:underline">লগইন করুন</a>
        </p>
    </div>
</div>
@endsection

