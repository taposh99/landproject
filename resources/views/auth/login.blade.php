@extends('layouts.app')

@section('title', 'লগইন - জমিরহাট')

@section('content')
<div class="max-w-md mx-auto px-4 py-12" x-data="loginForm()">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-xl mx-auto mb-2">
                জ
            </div>
            <h1 class="text-xl font-black text-slate-900">অ্যাকাউন্টে লগইন করুন</h1>
            <p class="text-xs text-slate-500 mt-1">জমি পোস্ট ও ড্যাশবোর্ড ব্যবহারের জন্য লগইন করুন</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs p-3.5 rounded-2xl mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">ইমেইল ঠিকানা</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email_input"
                    required 
                    value="{{ old('email') }}" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    placeholder="example@mail.com"
                >
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-xs font-bold text-slate-700">পাসওয়ার্ড</label>
                </div>
                <input 
                    type="password" 
                    name="password" 
                    id="password_input"
                    required 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    placeholder="••••••••"
                >
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-slate-600 font-medium">আমাকে মনে রাখুন</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl text-sm shadow-md transition active:scale-95">
                লগইন করুন
            </button>
        </form>

        <!-- Quick 1-Click Demo Accounts -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2.5">
                টেস্টিংয়ের জন্য দ্রুত ডেমো লগইন:
            </span>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" @click="setDemo('admin@landproject.com', 'password')" class="p-2 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-900 text-[11px] font-bold border border-purple-200 transition">
                    🛡️ অ্যাডমিন
                </button>
                <button type="button" @click="setDemo('seller@landproject.com', 'password')" class="p-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-900 text-[11px] font-bold border border-emerald-200 transition">
                    🏡 বিক্রেতা
                </button>
                <button type="button" @click="setDemo('buyer@landproject.com', 'password')" class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-900 text-[11px] font-bold border border-blue-200 transition">
                    👤 ক্রেতা
                </button>
            </div>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            অ্যাকাউন্ট নেই? 
            <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:underline">নতুন অ্যাকাউন্ট খুলুন</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function loginForm() {
        return {
            setDemo(email, pass) {
                document.getElementById('email_input').value = email;
                document.getElementById('password_input').value = pass;
            }
        }
    }
</script>
@endpush

