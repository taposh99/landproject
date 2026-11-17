@extends('layouts.app')

@section('title', 'ইউজার তালিকা - অ্যাডমিন প্যানেল')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <nav class="text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700">← ড্যাশবোর্ডে ফিরে যান</a>
            </nav>
            <h1 class="text-2xl font-black text-slate-900">নিবন্ধিত ইউজার ও রোল ম্যানেজমেন্ট</h1>
            <p class="text-xs text-slate-500">মোট {{ $users->total() }} জন ইউজার নিবন্ধিত আছেন</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase font-black tracking-wider text-[11px] border-y border-slate-200">
                <tr>
                    <th class="py-3 px-4">ইউজারের নাম</th>
                    <th class="py-3 px-4">ইমেইল</th>
                    <th class="py-3 px-4">মোবাইল নম্বর</th>
                    <th class="py-3 px-4">রোল (Role)</th>
                    <th class="py-3 px-4 text-center">পোস্ট সংখ্যা</th>
                    <th class="py-3 px-4">যোগদানের তারিখ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900">
                            {{ $user->name }}
                        </td>
                        <td class="py-3.5 px-4">
                            {{ $user->email }}
                        </td>
                        <td class="py-3.5 px-4 font-semibold text-slate-800">
                            {{ $user->phone ?? 'N/A' }}
                        </td>
                        <td class="py-3.5 px-4">
                            @foreach($user->roles as $role)
                                <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-bold 
                                    {{ $role->name === 'admin' ? 'bg-purple-100 text-purple-900' : ($role->name === 'seller' ? 'bg-emerald-100 text-emerald-900' : 'bg-blue-100 text-blue-900') }}">
                                    {{ $role->name === 'admin' ? 'অ্যাডমিন' : ($role->name === 'seller' ? 'বিক্রেতা' : 'ক্রেতা') }}
                                </span>
                            @endforeach
                        </td>
                        <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                            {{ $user->properties_count }} টি
                        </td>
                        <td class="py-3.5 px-4 text-slate-400">
                            {{ $user->created_at->format('d M, Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

