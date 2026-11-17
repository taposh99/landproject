<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $pendingProperties = Property::where('status', 'pending')
            ->with(['district', 'upazila', 'user'])
            ->latest()
            ->get();

        $approvedProperties = Property::where('status', 'approved')
            ->with(['district', 'upazila', 'user'])
            ->latest()
            ->paginate(10);

        $stats = [
            'pending' => Property::where('status', 'pending')->count(),
            'approved' => Property::where('status', 'approved')->count(),
            'rejected' => Property::where('status', 'rejected')->count(),
            'sold' => Property::where('status', 'sold')->count(),
            'users' => User::count(),
        ];

        return view('admin.dashboard', compact('pendingProperties', 'approvedProperties', 'stats'));
    }

    public function approve(Property $property): RedirectResponse
    {
        $property->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'জমিটির পোস্ট সফলভাবে অনুমোদন (Approve) করা হয়েছে এবং এটি এখন পাবলিকলি দেখা যাচ্ছে!');
    }

    public function reject(Request $request, Property $property): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $property->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason ?? 'কাগজপত্রে ত্রুটি অথবা তথ্যের অসংগতির কারণে পোস্টটি বাতিল করা হয়েছে।',
        ]);

        return back()->with('warning', 'জমিটির পোস্ট বাতিল (Reject) করা হয়েছে।');
    }

    public function toggleVerify(Property $property): RedirectResponse
    {
        $property->update([
            'is_verified' => ! $property->is_verified,
        ]);

        $statusText = $property->is_verified ? 'ভেরিফাইড ব্যাজ যোগ করা হয়েছে।' : 'ভেরিফাইড ব্যাজ তুলে নেওয়া হয়েছে।';

        return back()->with('success', $statusText);
    }

    public function toggleFeature(Property $property): RedirectResponse
    {
        $property->update([
            'is_featured' => ! $property->is_featured,
        ]);

        $statusText = $property->is_featured ? 'ফিচার্ড তালিকায় যুক্ত করা হয়েছে।' : 'ফিচার্ড তালিকা থেকে বাদ দেওয়া হয়েছে।';

        return back()->with('success', $statusText);
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->delete();

        return back()->with('success', 'জমিটির লিস্টিং ডাটাবেস থেকে সফলভাবে মুছে ফেলা হয়েছে।');
    }

    public function users(): View
    {
        $users = User::with('roles')
            ->withCount('properties')
            ->latest()
            ->paginate(15);

        return view('admin.users', compact('users'));
    }
}
