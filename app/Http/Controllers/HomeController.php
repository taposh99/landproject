<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Property;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\Village;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $districts = District::with(['upazilas.unions.villages'])->get();
        $palashUpazila = Upazila::with(['unions.villages'])->where('name', 'Palash')->first();

        // Palash specific properties
        $palashProperties = Property::approved()
            ->when($palashUpazila, function ($query) use ($palashUpazila) {
                $query->where('upazila_id', $palashUpazila->id);
            })
            ->with(['district', 'upazila', 'union', 'village', 'images', 'user'])
            ->latest()
            ->take(6)
            ->get();

        // Featured properties overall
        $featuredProperties = Property::approved()
            ->where('is_featured', true)
            ->with(['district', 'upazila', 'union', 'village', 'images', 'user'])
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

    public function getUnions(Request $request): JsonResponse
    {
        $upazilaId = $request->get('upazila_id');
        $unions = Union::where('upazila_id', $upazilaId)->get(['id', 'name', 'bn_name']);

        return response()->json($unions);
    }

    public function getVillages(Request $request): JsonResponse
    {
        $unionId = $request->get('union_id');
        $villages = Village::where('union_id', $unionId)->get(['id', 'name', 'bn_name']);

        return response()->json($villages);
    }
}
