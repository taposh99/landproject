<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Property;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $sellerRole = Role::firstOrCreate(['name' => 'seller']);
        $buyerRole = Role::firstOrCreate(['name' => 'buyer']);

        // 2. Create Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@landproject.com'],
            [
                'name' => 'Admin User',
                'phone' => '01711000001',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles([$adminRole]);

        $seller = User::firstOrCreate(
            ['email' => 'seller@landproject.com'],
            [
                'name' => 'জমির মালিক (করিম সাহেব)',
                'phone' => '01812345678',
                'password' => Hash::make('password'),
            ]
        );
        $seller->syncRoles([$sellerRole]);

        $buyer = User::firstOrCreate(
            ['email' => 'buyer@landproject.com'],
            [
                'name' => 'ক্রেতা (রহিম আহমেদ)',
                'phone' => '01912345678',
                'password' => Hash::make('password'),
            ]
        );
        $buyer->syncRoles([$buyerRole]);

        // 3. Create Locations (Focus on Narsingdi & Palash)
        $narsingdi = District::firstOrCreate(
            ['name' => 'Narsingdi'],
            ['bn_name' => 'নরসিংদী']
        );

        $dhaka = District::firstOrCreate(
            ['name' => 'Dhaka'],
            ['bn_name' => 'ঢাকা']
        );

        $palash = Upazila::firstOrCreate(
            ['district_id' => $narsingdi->id, 'name' => 'Palash'],
            ['bn_name' => 'পলাশ']
        );

        Upazila::firstOrCreate(
            ['district_id' => $narsingdi->id, 'name' => 'Narsingdi Sadar'],
            ['bn_name' => 'নরসিংদী সদর']
        );

        Upazila::firstOrCreate(
            ['district_id' => $narsingdi->id, 'name' => 'Shibpur'],
            ['bn_name' => 'শিবপুর']
        );

        Upazila::firstOrCreate(
            ['district_id' => $narsingdi->id, 'name' => 'Raipura'],
            ['bn_name' => 'রায়পুরা']
        );

        Upazila::firstOrCreate(
            ['district_id' => $narsingdi->id, 'name' => 'Belabo'],
            ['bn_name' => 'বেলাবো']
        );

        Upazila::firstOrCreate(
            ['district_id' => $narsingdi->id, 'name' => 'Monohardi'],
            ['bn_name' => 'মনোহরদী']
        );

        // 4. Create Unions and Villages under Palash Upazila
        // Union 1: Ghorashal Pourashava
        $ghorashal = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Ghorashal'],
            ['bn_name' => 'ঘোড়াশাল পৌরসভা']
        );
        $chamrab = Village::firstOrCreate(['union_id' => $ghorashal->id, 'name' => 'Chamrab'], ['bn_name' => 'চামড়াব']);
        $bhagyerpara = Village::firstOrCreate(['union_id' => $ghorashal->id, 'name' => 'Bhagyerpara'], ['bn_name' => 'ভাগ্যেরপাড়া']);
        $palashBazar = Village::firstOrCreate(['union_id' => $ghorashal->id, 'name' => 'Palash Bazar'], ['bn_name' => 'পলাশ বাজার']);
        $tengorpara = Village::firstOrCreate(['union_id' => $ghorashal->id, 'name' => 'Tengorpara'], ['bn_name' => 'টেঙ্গরপাড়া']);

        // Union 2: Charsindur Union
        $charsindur = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Charsindur'],
            ['bn_name' => 'চরসিন্দুর ইউনিয়ন']
        );
        $kajirchar = Village::firstOrCreate(['union_id' => $charsindur->id, 'name' => 'Kajirchar'], ['bn_name' => 'কাজীরচর']);
        $charsindurBazar = Village::firstOrCreate(['union_id' => $charsindur->id, 'name' => 'Charsindur Bazar'], ['bn_name' => 'চরসিন্দুর বাজার']);
        $madhyerchar = Village::firstOrCreate(['union_id' => $charsindur->id, 'name' => 'Madhyerchar'], ['bn_name' => 'মধ্যেরচর']);

        // Union 3: Danga Union
        $danga = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Danga'],
            ['bn_name' => 'ডাঙ্গা ইউনিয়ন']
        );
        $dangaBazar = Village::firstOrCreate(['union_id' => $danga->id, 'name' => 'Danga Bazar'], ['bn_name' => 'ডাঙ্গা বাজার']);
        $kajair = Village::firstOrCreate(['union_id' => $danga->id, 'name' => 'Kajair'], ['bn_name' => 'কাজৈর']);
        $bhatpara = Village::firstOrCreate(['union_id' => $danga->id, 'name' => 'Bhatpara'], ['bn_name' => 'ভাটপাড়া']);

        // Union 4: Jinardi Union
        $jinardi = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Jinardi'],
            ['bn_name' => 'জিনারদী ইউনিয়ন']
        );
        $jinardiStation = Village::firstOrCreate(['union_id' => $jinardi->id, 'name' => 'Jinardi Station'], ['bn_name' => 'জিনারদী স্টেশন']);
        $chandanbari = Village::firstOrCreate(['union_id' => $jinardi->id, 'name' => 'Chandanbari'], ['bn_name' => 'চন্দনবাড়ী']);

        // Union 5: Gazaria Union
        $gazaria = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Gazaria'],
            ['bn_name' => 'গজারিয়া ইউনিয়ন']
        );
        $gazariaVillage = Village::firstOrCreate(['union_id' => $gazaria->id, 'name' => 'Gazaria'], ['bn_name' => 'গজারিয়া গ্রাম']);
        $baghpara = Village::firstOrCreate(['union_id' => $gazaria->id, 'name' => 'Baghpara'], ['bn_name' => 'বাঘপাড়া']);

        // 5. Sample Land Listings with Union & Village linked
        $properties = [
            [
                'user_id' => $seller->id,
                'district_id' => $narsingdi->id,
                'upazila_id' => $palash->id,
                'union_id' => $ghorashal->id,
                'village_id' => $chamrab->id,
                'mouza_area' => 'চামড়াব, ঘোড়াশাল',
                'title' => 'ঘোড়াশাল মেইন রোডের পাশে ৫ শতাংশ নিষ্কন্টক আবাসিক প্লট',
                'slug' => 'ghorashal-main-road-5-decimal-residential-plot-'.Str::random(5),
                'description' => 'পলাশ উপজেলার অন্তর্গত ঘোড়াশাল পৌরসভার চামড়াব এলাকায় মেইন হাইওয়ের সাথে লাগানো চমৎকার ৫ শতাংশ আবাসিক জমি। সামনে ২০ ফিট প্রশস্ত পাকা রাস্তা রয়েছে। গ্যাস ও বিদ্যুৎ লাইন সংযোগের সুবিধা বিদ্যমান। বাড়ি নির্মাণ কিংবা বাউন্ডারি দিয়ে রাখার জন্য আদর্শ জায়গা। সকল কাগজপত্র (খতিয়ান, খারিজ, হালনাগাদ খাজনা) ১০০% নিষ্কন্টক।',
                'land_type' => 'residential',
                'land_size' => 5.00,
                'size_unit' => 'decimal',
                'price' => 3500000.00, // 35 Lakh
                'price_type' => 'total',
                'is_negotiable' => true,
                'road_width_feet' => 20,
                'road_type' => 'paved',
                'address' => 'চামড়াব, ঘোড়াশাল পৌরসভা, পলাশ, নরসিংদী',
                'khatian_type' => 'RS / BS',
                'daag_no' => '১০৫২',
                'khatian_no' => '৮৭০',
                'is_mutation_done' => true,
                'is_tax_updated' => true,
                'contact_number' => '01812345678',
                'whatsapp_number' => '01812345678',
                'status' => 'approved',
                'is_verified' => true,
                'is_featured' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80',
                'youtube_url' => 'https://www.youtube.com/watch?v=07d2dXHYb94',
            ],
            [
                'user_id' => $seller->id,
                'district_id' => $narsingdi->id,
                'upazila_id' => $palash->id,
                'union_id' => $charsindur->id,
                'village_id' => $charsindurBazar->id,
                'mouza_area' => 'চরসিন্দুর বাজার',
                'title' => 'চরসিন্দুর বাজারের সাথে ৩.৫ শতাংশ বাণিজ্যিক প্লট বিক্রয়',
                'slug' => 'charsindur-bazar-commercial-plot-'.Str::random(5),
                'description' => 'পলাশ উপজেলার চরসিন্দুর ইউনিয়নের মূল বাজার কেন্দ্রস্থলে ৩.৫ শতাংশ বাণিজ্যিক জমি বিক্রয় হবে। মার্কেট, দোকানপাট বা বাণিজ্যিক গোডাউনের জন্য অতি চমৎকার লোকেশন। সামনে ২৫ ফিট পিচ ঢালাই রাস্তা। চতুর্দিকে মার্কেট রয়েছে। কাগজপত্র সম্পূর্ণ ফ্রেশ ও নির্ভেজাল। সরাসরি মালিকের সাথে কথা বলে বায়না করতে পারবেন।',
                'land_type' => 'commercial',
                'land_size' => 3.50,
                'size_unit' => 'decimal',
                'price' => 4500000.00, // 45 Lakh
                'price_type' => 'total',
                'is_negotiable' => false,
                'road_width_feet' => 25,
                'road_type' => 'paved',
                'address' => 'চরসিন্দুর বাজার মোড়, পলাশ, নরসিংদী',
                'khatian_type' => 'RS',
                'daag_no' => '৩২১',
                'khatian_no' => '১৪৫',
                'is_mutation_done' => true,
                'is_tax_updated' => true,
                'contact_number' => '01812345678',
                'whatsapp_number' => '01812345678',
                'status' => 'approved',
                'is_verified' => true,
                'is_featured' => false,
                'featured_image' => 'https://images.unsplash.com/photo-1524813686514-a57563d77d66?auto=format&fit=crop&w=1200&q=80',
                'youtube_url' => null,
            ],
            [
                'user_id' => $seller->id,
                'district_id' => $narsingdi->id,
                'upazila_id' => $palash->id,
                'union_id' => $danga->id,
                'village_id' => $kajair->id,
                'mouza_area' => 'কাজৈর, ডাঙ্গা',
                'title' => 'পলাশ ডাঙ্গা শিল্পাঞ্চল রোডের কাছে ১০ কাঠা উঁচু নাল/কৃষি জমি',
                'slug' => 'danga-palash-10-katha-land-'.Str::random(5),
                'description' => 'পলাশ উপজেলার ডাঙ্গা ইউনিয়নের কাজৈর গ্রামে চমৎকার ১০ কাঠা উঁচু জমি। চতুর্দিকে কারখানা ও আবাসিক বসতি গড়ে উঠছে। এগ্রো ফার্ম, পোল্ট্রি, ছোট কারখানা অথবা ভবিষ্যৎ বিনিয়োগের জন্য অসাধারণ একটি প্লট। বর্ষায় পানি উঠে না। ১২ ফিট ইটের সোলিং রাস্তা বিদ্যমান। জরুরি টাকার প্রয়োজনে বিক্রি করা হচ্ছে।',
                'land_type' => 'agricultural',
                'land_size' => 10.00,
                'size_unit' => 'katha',
                'price' => 2800000.00, // 28 Lakh
                'price_type' => 'total',
                'is_negotiable' => true,
                'road_width_feet' => 12,
                'road_type' => 'brick',
                'address' => 'কাজৈর গ্রাম, ডাঙ্গা ইউনিয়ন, পলাশ, নরসিংদী',
                'khatian_type' => 'SA / RS',
                'daag_no' => '৬১২',
                'khatian_no' => '২৯০',
                'is_mutation_done' => true,
                'is_tax_updated' => true,
                'contact_number' => '01712000000',
                'whatsapp_number' => '01712000000',
                'status' => 'approved',
                'is_verified' => false,
                'is_featured' => false,
                'featured_image' => 'https://images.unsplash.com/photo-1500076656116-558758c991c1?auto=format&fit=crop&w=1200&q=80',
                'youtube_url' => null,
            ],
            [
                'user_id' => $seller->id,
                'district_id' => $narsingdi->id,
                'upazila_id' => $palash->id,
                'union_id' => $jinardi->id,
                'village_id' => $jinardiStation->id,
                'mouza_area' => 'জিনারদী স্টেশন',
                'title' => 'জিনারদী রেলওয়ে স্টেশন সংলগ্ন ৪ শতাংশ ভিটা জমি (নতুন লিস্টিং)',
                'slug' => 'jinardi-railway-station-4-decimal-land-'.Str::random(5),
                'description' => 'পলাশ উপজেলার জিনারদী ইউনিয়ন পরিষদ ও রেলওয়ে স্টেশনের কাছে নিরিবিলি পরিবেশে বাড়ি করার উপযোগী ৪ শতাংশ উঁচু ভিটা জমি। বিদ্যুৎ সংযোগ পাশেই আছে। এটি একটি পেন্ডিং পোস্ট যা অ্যাডমিন অ্যাপ্রুভালের অপেক্ষায় রয়েছে।',
                'land_type' => 'residential',
                'land_size' => 4.00,
                'size_unit' => 'decimal',
                'price' => 1800000.00,
                'price_type' => 'total',
                'is_negotiable' => true,
                'road_width_feet' => 10,
                'road_type' => 'dirt',
                'address' => 'জিনারদী স্টেশন এলাকা, পলাশ, নরসিংদী',
                'khatian_type' => 'RS',
                'daag_no' => '৭৮',
                'khatian_no' => '৫৬',
                'is_mutation_done' => false,
                'is_tax_updated' => true,
                'contact_number' => '01911223344',
                'whatsapp_number' => '01911223344',
                'status' => 'pending', // Pending for admin approval demo!
                'is_verified' => false,
                'is_featured' => false,
                'featured_image' => 'https://images.unsplash.com/photo-1513836279014-a89f7a76ae86?auto=format&fit=crop&w=1200&q=80',
                'youtube_url' => null,
            ],
        ];

        foreach ($properties as $propData) {
            Property::create($propData);
        }
    }
}
