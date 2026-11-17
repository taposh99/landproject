<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Property;
use App\Models\Upazila;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $districts = District::with('upazilas')->get();
        $palashUpazila = Upazila::where('name', 'Palash')->first();

        // Palash specific properties
        $palashProperties = Property::approved()
            ->when($palashUpazila, function ($query) use ($palashUpazila) {
                $query->where('upazila_id', $palashUpazila->id);
            })
            ->with(['district', 'upazila'])
            ->latest()
            ->take(6)
            ->get();

        // Featured properties overall
        $featuredProperties = Property::approved()
            ->where('is_featured', true)
            ->with(['district', 'upazila'])
            ->latest()
            ->take(6)
            ->get();

        // Stats
        $stats = [
            'total_lands' => Property::approved()->count(),
            'palash_lands' => $palashUpazila ? Property::approved()->where('upazila_id', $palashUpazila->id)->count() : 0,
            'verified_lands' => Property::approved()->where('is_verified', true)->count(),
        ];

        return view('home', compact('districts', 'palashProperties', 'featuredProperties', 'stats', 'palashUpazila'));
    }

    public function converter(): View
    {
        return view('converter');
    }

    public function getUpazilas(Request $request): JsonResponse
    {
        $districtId = $request->get('district_id');
        $upazilas = Upazila::where('district_id', $districtId)->get(['id', 'name', 'bn_name']);

        return response()->json($upazilas);
    }
}
