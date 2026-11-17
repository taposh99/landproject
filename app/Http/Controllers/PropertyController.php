<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Favorite;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\Upazila;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $query = Property::approved()->with(['district', 'upazila', 'user']);

        // Filter: District
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        // Filter: Upazila (e.g. Palash)
        if ($request->filled('upazila_id')) {
            $query->where('upazila_id', $request->upazila_id);
        }

        // Filter: Land Type
        if ($request->filled('land_type')) {
            $query->where('land_type', $request->land_type);
        }

        // Filter: Verified Only
        if ($request->boolean('verified_only')) {
            $query->where('is_verified', true);
        }

        // Filter: Search Keyword
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('mouza_area', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter: Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'size_desc' => $query->orderBy('land_size', 'desc'),
            default => $query->latest(),
        };

        $properties = $query->paginate(9)->withQueryString();
        $districts = District::with('upazilas')->get();
        $selectedUpazila = $request->filled('upazila_id') ? Upazila::find($request->upazila_id) : null;

        return view('properties.index', compact('properties', 'districts', 'selectedUpazila'));
    }

    public function show(string $slug): View
    {
        $property = Property::where('slug', $slug)
            ->with(['district', 'upazila', 'user', 'images'])
            ->firstOrFail();

        // Increment view count
        $property->increment('views_count');

        // Related properties in same upazila/district
        $relatedProperties = Property::approved()
            ->where('id', '!=', $property->id)
            ->where('upazila_id', $property->upazila_id)
            ->take(3)
            ->get();

        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Favorite::where('user_id', Auth::id())
                ->where('property_id', $property->id)
                ->exists();
        }

        return view('properties.show', compact('property', 'relatedProperties', 'isFavorited'));
    }

    public function create(): View
    {
        $districts = District::with('upazilas')->get();

        return view('properties.create', compact('districts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'exists:districts,id'],
            'upazila_id' => ['required', 'exists:upazilas,id'],
            'mouza_area' => ['nullable', 'string', 'max:100'],
            'land_type' => ['required', 'in:residential,commercial,agricultural,industrial'],
            'land_size' => ['required', 'numeric', 'min:0.1'],
            'size_unit' => ['required', 'in:decimal,katha,bigha,acre'],
            'price' => ['required', 'numeric', 'min:1000'],
            'price_type' => ['required', 'in:total,per_decimal,per_katha'],
            'is_negotiable' => ['nullable', 'boolean'],
            'road_width_feet' => ['nullable', 'integer', 'min:1'],
            'road_type' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'khatian_type' => ['nullable', 'string'],
            'daag_no' => ['nullable', 'string'],
            'khatian_no' => ['nullable', 'string'],
            'is_mutation_done' => ['nullable', 'boolean'],
            'is_tax_updated' => ['nullable', 'boolean'],
            'contact_number' => ['required', 'string', 'max:20'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'description' => ['required', 'string', 'min:20'],
            'featured_image' => ['nullable', 'url'],
            'image_file' => ['nullable', 'image', 'max:3072'],
        ]);

        $featuredImageUrl = $validated['featured_image'] ?? null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('properties', 'public');
            $featuredImageUrl = asset('storage/'.$path);
        }

        if (empty($featuredImageUrl)) {
            // Default placeholder land image
            $featuredImageUrl = 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80';
        }

        $property = Property::create([
            'user_id' => Auth::id(),
            'district_id' => $validated['district_id'],
            'upazila_id' => $validated['upazila_id'],
            'mouza_area' => $validated['mouza_area'] ?? null,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(6),
            'description' => $validated['description'],
            'land_type' => $validated['land_type'],
            'land_size' => $validated['land_size'],
            'size_unit' => $validated['size_unit'],
            'price' => $validated['price'],
            'price_type' => $validated['price_type'],
            'is_negotiable' => $request->boolean('is_negotiable', true),
            'road_width_feet' => $validated['road_width_feet'] ?? null,
            'road_type' => $validated['road_type'] ?? null,
            'address' => $validated['address'] ?? null,
            'khatian_type' => $validated['khatian_type'] ?? null,
            'daag_no' => $validated['daag_no'] ?? null,
            'khatian_no' => $validated['khatian_no'] ?? null,
            'is_mutation_done' => $request->boolean('is_mutation_done'),
            'is_tax_updated' => $request->boolean('is_tax_updated'),
            'contact_number' => $validated['contact_number'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'featured_image' => $featuredImageUrl,
            'status' => 'pending', // Pending approval!
            'is_verified' => false,
        ]);

        return redirect()->route('my.properties')->with(
            'success',
            'আপনার জমির পোস্টটি সফলভাবে জমা হয়েছে! অ্যাডমিন যাচাই করে অনুমোদন (Approve) দিলে এটি সাধারণ ব্যবহারকারীদের জন্য উন্মুক্ত হবে।'
        );
    }

    public function myProperties(): View
    {
        $properties = Property::where('user_id', Auth::id())
            ->with(['district', 'upazila'])
            ->latest()
            ->paginate(10);

        return view('properties.my-properties', compact('properties'));
    }

    public function markAsSold(Property $property): RedirectResponse
    {
        if ($property->user_id !== Auth::id() && ! Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $property->update(['status' => 'sold']);

        return back()->with('success', 'জমিটি সফলভাবে "বিক্রিত (Sold)" হিসেবে মার্ক করা হয়েছে!');
    }

    public function submitInquiry(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email'],
            'message' => ['required', 'string', 'max:1000'],
            'preferred_visit_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        Inquiry::create([
            'property_id' => $property->id,
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'message' => $validated['message'],
            'preferred_visit_date' => $validated['preferred_visit_date'] ?? null,
            'status' => 'new',
        ]);

        return back()->with('success', 'আপনার মেসেজ এবং ভিজিট রিকোয়েস্ট সফলভাবে পাঠানো হয়েছে! জমির মালিক শীঘ্রই আপনার সাথে যোগাযোগ করবেন।');
    }

    public function toggleFavorite(Property $property): RedirectResponse
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('property_id', $property->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $msg = 'জমিটি আপনার পছন্দের তালিকা থেকে বাদ দেওয়া হয়েছে।';
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'property_id' => $property->id,
            ]);
            $msg = 'জমিটি আপনার পছন্দের তালিকায় যোগ করা হয়েছে!';
        }

        return back()->with('success', $msg);
    }
}
