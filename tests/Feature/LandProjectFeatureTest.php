<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Property;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LandProjectFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'seller']);
        Role::firstOrCreate(['name' => 'buyer']);
    }

    public function test_home_page_loads_and_displays_palash_section(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('পলাশ');
        $response->assertSee('জমির পরিমাপ কনভার্টার');
    }

    public function test_properties_listing_can_filter_by_upazila(): void
    {
        $palash = Upazila::where('name', 'Palash')->first();
        $this->assertNotNull($palash);

        $response = $this->get(route('properties.index', ['upazila_id' => $palash->id]));

        $response->assertStatus(200);
        $response->assertSee('পলাশ');
    }

    public function test_pending_property_is_not_visible_on_public_list(): void
    {
        $district = District::first();
        $upazila = Upazila::first();
        $seller = User::factory()->create();
        $seller->assignRole('seller');

        $pendingProperty = Property::create([
            'user_id' => $seller->id,
            'district_id' => $district->id,
            'upazila_id' => $upazila->id,
            'mouza_area' => 'পরীক্ষামূলক এলাকা',
            'title' => 'টেস্ট পেন্ডিং জমি '.Str::random(5),
            'slug' => 'test-pending-land-'.Str::random(6),
            'description' => 'এই জমিটি এখনো অ্যাডমিন অ্যাপ্রুভ করেনি।',
            'land_type' => 'residential',
            'land_size' => 5,
            'size_unit' => 'decimal',
            'price' => 2000000,
            'price_type' => 'total',
            'contact_number' => '01700000000',
            'status' => 'pending',
        ]);

        $response = $this->get(route('properties.index'));
        $response->assertDontSee($pendingProperty->title);
    }

    public function test_admin_can_approve_pending_property(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $district = District::first();
        $upazila = Upazila::first();
        $seller = User::factory()->create();
        $seller->assignRole('seller');

        $property = Property::create([
            'user_id' => $seller->id,
            'district_id' => $district->id,
            'upazila_id' => $upazila->id,
            'mouza_area' => 'পলাশ বাজার',
            'title' => 'অ্যাপ্রুভ করার জন্য টেস্ট জমি '.Str::random(5),
            'slug' => 'test-approve-land-'.Str::random(6),
            'description' => 'টেস্ট জমি ডেসক্রিপশন',
            'land_type' => 'commercial',
            'land_size' => 3,
            'size_unit' => 'decimal',
            'price' => 1500000,
            'price_type' => 'total',
            'contact_number' => '01711111111',
            'status' => 'pending',
        ]);

        // Non-admin cannot approve
        $this->actingAs($seller)
            ->post(route('admin.properties.approve', $property->id))
            ->assertStatus(403);

        // Admin approves
        $this->actingAs($admin)
            ->post(route('admin.properties.approve', $property->id))
            ->assertRedirect();

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'status' => 'approved',
        ]);

        // Now visible on public listing
        $response = $this->get(route('properties.index'));
        $response->assertSee($property->title);
    }

    public function test_can_filter_properties_by_union(): void
    {
        $union = Union::where('name', 'Ghorashal')->first();
        $this->assertNotNull($union);

        $response = $this->get(route('properties.index', ['union_id' => $union->id]));
        $response->assertStatus(200);
        $response->assertSee('ঘোড়াশাল');
    }
}
