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

        // 4. Create Complete Real Unions and Villages under Palash Upazila

        // -------------------------------------------------------------
        // Union 1: গজারিয়া ইউনিয়ন (Gazaria Union) - All 22 official villages
        // -------------------------------------------------------------
        $gazaria = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Gazaria'],
            ['bn_name' => 'গজারিয়া ইউনিয়ন']
        );
        $gazariaVillages = [
            ['name' => 'Gazaria', 'bn_name' => 'গজারিয়া গ্রাম'],
            ['name' => 'Rampur', 'bn_name' => 'রামপুর'],
            ['name' => 'Pitambardi', 'bn_name' => 'পিতাম্বরদী'],
            ['name' => 'Sekandardi', 'bn_name' => 'সেকান্দরদী'],
            ['name' => 'Syederkhola', 'bn_name' => 'সৈয়দেরখোলা'],
            ['name' => 'Charkarardi', 'bn_name' => 'চরকারারদী'],
            ['name' => 'Joypura', 'bn_name' => 'জয়পুরা'],
            ['name' => 'Sarkarchar', 'bn_name' => 'সরকারচর'],
            ['name' => 'Ichhakhali', 'bn_name' => 'ইছাখালী'],
            ['name' => 'Khashaola', 'bn_name' => 'খাসহাওলা'],
            ['name' => 'Char Mahmudpur', 'bn_name' => 'চরমাহমুদপুর'],
            ['name' => 'Nitainandi', 'bn_name' => 'নিতাইনন্দী'],
            ['name' => 'Dhaluarchar', 'bn_name' => 'ঢালুয়ারচর'],
            ['name' => 'Ramainandi', 'bn_name' => 'রামাইনন্দী'],
            ['name' => 'Nimainandi', 'bn_name' => 'নিমাইনন্দী'],
            ['name' => 'Mucharkanda', 'bn_name' => 'মুছারকান্দা'],
            ['name' => 'Narsingharchar', 'bn_name' => 'নরসিংহারচর'],
            ['name' => 'Dhanairchar', 'bn_name' => 'ধনাইরচর'],
            ['name' => 'Noakanda', 'bn_name' => 'নোয়াকান্দা'],
            ['name' => 'Dorichar', 'bn_name' => 'দড়িচর'],
            ['name' => 'Baktarpur', 'bn_name' => 'বক্তারপুর'],
            ['name' => 'Baghpara', 'bn_name' => 'বাঘপাড়া'],
        ];
        foreach ($gazariaVillages as $gv) {
            Village::firstOrCreate(['union_id' => $gazaria->id, 'name' => $gv['name']], ['bn_name' => $gv['bn_name']]);
        }

        // -------------------------------------------------------------
        // Union 2: চরসিন্দুর ইউনিয়ন (Charsindur Union) - All 16 official villages
        // -------------------------------------------------------------
        $charsindur = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Charsindur'],
            ['bn_name' => 'চরসিন্দুর ইউনিয়ন']
        );
        $charsindurVillages = [
            ['name' => 'Charsindur', 'bn_name' => 'চরসিন্দুর গ্রাম'],
            ['name' => 'Charsindur Bazar', 'bn_name' => 'চরসিন্দুর বাজার'],
            ['name' => 'Kajirchar', 'bn_name' => 'কাজীরচর'],
            ['name' => 'Cholna', 'bn_name' => 'চলনা'],
            ['name' => 'Char Madhabdi', 'bn_name' => 'চর মাধবদী'],
            ['name' => 'Sultanpur', 'bn_name' => 'সুলতানপুর'],
            ['name' => 'Dakshin Deora', 'bn_name' => 'দক্ষিন দেওড়া'],
            ['name' => 'Fulbaria', 'bn_name' => 'ফুলবাড়িয়া'],
            ['name' => 'Gokulnagar', 'bn_name' => 'গকুলনগর'],
            ['name' => 'Kauyadi', 'bn_name' => 'কাউয়াদী / কাউরিয়া'],
            ['name' => 'Char Alinagar', 'bn_name' => 'চর আলীনগর'],
            ['name' => 'Char Madhyanagar', 'bn_name' => 'চর মধ্যনগর'],
            ['name' => 'Uttar Deora', 'bn_name' => 'উত্তর দেওড়া'],
            ['name' => 'Malita', 'bn_name' => 'মালিতা'],
            ['name' => 'Lohar Kanda', 'bn_name' => 'লোহার কান্দা'],
            ['name' => 'Kalapaika', 'bn_name' => 'কালাপাইকা'],
        ];
        foreach ($charsindurVillages as $cv) {
            Village::firstOrCreate(['union_id' => $charsindur->id, 'name' => $cv['name']], ['bn_name' => $cv['bn_name']]);
        }

        // -------------------------------------------------------------
        // Union 3: ডাঙ্গা ইউনিয়ন (Danga Union) - All 14 official villages
        // -------------------------------------------------------------
        $danga = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Danga'],
            ['bn_name' => 'ডাঙ্গা ইউনিয়ন']
        );
        $dangaVillages = [
            ['name' => 'Danga', 'bn_name' => 'ডাংগা গ্রাম'],
            ['name' => 'Danga Bazar', 'bn_name' => 'ডাঙ্গা বাজার'],
            ['name' => 'Kajair', 'bn_name' => 'কাজৈর'],
            ['name' => 'Islampara', 'bn_name' => 'ইসলামপাড়া'],
            ['name' => 'Kajirchar', 'bn_name' => 'কাজিরচর'],
            ['name' => 'Santanpara', 'bn_name' => 'সান্তানপাড়া'],
            ['name' => 'Khilpara / Kandapara', 'bn_name' => 'খিলপাড়া / কান্দাপাড়া'],
            ['name' => 'Bhirinda', 'bn_name' => 'ভিরিন্দা'],
            ['name' => 'Galimpur', 'bn_name' => 'গালিমপুর'],
            ['name' => 'Joynagar', 'bn_name' => 'জয়নগর'],
            ['name' => 'Hasanhatta', 'bn_name' => 'হাসানহাটা'],
            ['name' => 'Kenduab', 'bn_name' => 'কেন্দুয়াব'],
            ['name' => 'Taltala', 'bn_name' => 'তালতলা / তালতলী'],
            ['name' => 'Bhatpara', 'bn_name' => 'ভাটপাড়া'],
        ];
        foreach ($dangaVillages as $dv) {
            Village::firstOrCreate(['union_id' => $danga->id, 'name' => $dv['name']], ['bn_name' => $dv['bn_name']]);
        }

        // -------------------------------------------------------------
        // Union 4: জিনারদী ইউনিয়ন (Jinardi Union) - Official villages
        // -------------------------------------------------------------
        $jinardi = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Jinardi'],
            ['bn_name' => 'জিনারদী ইউনিয়ন']
        );
        $jinardiVillages = [
            ['name' => 'Jinardi', 'bn_name' => 'জিনারদী'],
            ['name' => 'Jinardi Station', 'bn_name' => 'জিনারদী স্টেশন এলাকা'],
            ['name' => 'Chandanbari', 'bn_name' => 'চন্দনবাড়ী'],
            ['name' => 'Bararchar', 'bn_name' => 'বাড়ারচর'],
            ['name' => 'Gayeshpur', 'bn_name' => 'গয়েশপুর'],
            ['name' => 'Raghabdi', 'bn_name' => 'রাঘবদী'],
            ['name' => 'Charnagardi', 'bn_name' => 'চরনগরদী'],
            ['name' => 'Palasherchar', 'bn_name' => 'পলাশেরচর'],
            ['name' => 'Majherchar', 'bn_name' => 'মাঝেরচর'],
            ['name' => 'Parulia', 'bn_name' => 'পারুলিয়া'],
            ['name' => 'Madhya Parulia', 'bn_name' => 'মধ্য পারুলিয়া'],
            ['name' => 'Charpara', 'bn_name' => 'চরপাড়া'],
            ['name' => 'Uttar Chandan', 'bn_name' => 'উত্তরচন্দন'],
            ['name' => 'Dakshin Uttar Chandan', 'bn_name' => 'দক্ষিণ উত্তরচন্দন'],
            ['name' => 'Targaon', 'bn_name' => 'তারগাঁও'],
            ['name' => 'Chhoto Targaon', 'bn_name' => 'ছোট তারগাঁও'],
            ['name' => 'Nagarnarsingpur', 'bn_name' => 'নগরনরসিংপুর'],
            ['name' => 'Raban', 'bn_name' => 'রাবান'],
            ['name' => 'Sattakia', 'bn_name' => 'সাতটেকিয়া'],
            ['name' => 'Bhalukapara', 'bn_name' => 'ভালুকাপাড়া'],
            ['name' => 'Bilpar', 'bn_name' => 'বিলপাড়'],
            ['name' => 'Chhaydharia', 'bn_name' => 'ছয়ধরিয়া'],
            ['name' => 'Barab', 'bn_name' => 'বরাব'],
            ['name' => 'Baghab', 'bn_name' => 'বাঘাব'],
            ['name' => 'Panchbhag', 'bn_name' => 'পাঁচভাগ'],
            ['name' => 'Sanerbari', 'bn_name' => 'সানেরবাড়ী'],
            ['name' => 'Gabtali', 'bn_name' => 'গাবতলী'],
            ['name' => 'Panditpara', 'bn_name' => 'পন্ডিতপাড়া'],
            ['name' => 'Chhoto Lakshmipur', 'bn_name' => 'ছোট লক্ষ্মীপুর'],
            ['name' => 'Goalbathan', 'bn_name' => 'গোয়ালবাথান'],
            ['name' => 'Kuraitoli', 'bn_name' => 'কুড়াইতলী'],
            ['name' => 'Boribari', 'bn_name' => 'বড়িবাড়ী'],
            ['name' => 'Kataber', 'bn_name' => 'কাটাবেড়'],
        ];
        foreach ($jinardiVillages as $jv) {
            Village::firstOrCreate(['union_id' => $jinardi->id, 'name' => $jv['name']], ['bn_name' => $jv['bn_name']]);
        }

        // -------------------------------------------------------------
        // Union 5: ঘোড়াশাল পৌরসভা (Ghorashal Pourashava / Palash) - All wards & mohollas
        // -------------------------------------------------------------
        $ghorashal = Union::firstOrCreate(
            ['upazila_id' => $palash->id, 'name' => 'Ghorashal'],
            ['bn_name' => 'ঘোড়াশাল পৌরসভা']
        );
        $ghorashalVillages = [
            ['name' => 'Ghorashal Bazar', 'bn_name' => 'ঘোড়াশাল বাজার'],
            ['name' => 'Ghorashal Notun Bazar', 'bn_name' => 'ঘোড়াশাল নতুন বাজার'],
            ['name' => 'Chamrab', 'bn_name' => 'চামড়াব'],
            ['name' => 'Bhagyerpara', 'bn_name' => 'ভাগ্যেরপাড়া'],
            ['name' => 'Tengorpara', 'bn_name' => 'টেঙ্গরপাড়া'],
            ['name' => 'Kathaliapara', 'bn_name' => 'কাঁঠালিয়াপাড়া'],
            ['name' => 'Balia', 'bn_name' => 'বালিয়া'],
            ['name' => 'Khanepur', 'bn_name' => 'খানেপুর'],
            ['name' => 'Palash Gorpara', 'bn_name' => 'পলাশ গড়পাড়া'],
            ['name' => 'Palash Dorihaolapara', 'bn_name' => 'পলাশ দড়িহাওলাপাড়া'],
            ['name' => 'Palash Bhagiapara', 'bn_name' => 'পলাশ ভাগিয়াপাড়া'],
            ['name' => 'Purba Palash', 'bn_name' => 'পূর্ব পলাশ'],
            ['name' => 'Notun Palash Bonik Para', 'bn_name' => 'নতুন পলাশ বণিক পাড়া'],
            ['name' => 'Power Plant Area', 'bn_name' => 'ঘোড়াশাল তাপ বিদ্যুৎ কেন্দ্র এলাকা'],
            ['name' => 'Uttar Charpara', 'bn_name' => 'উত্তর চরপাড়া'],
            ['name' => 'Dakshin Charpara', 'bn_name' => 'দক্ষিণ চরপাড়া'],
            ['name' => 'Tekpara', 'bn_name' => 'টেকপাড়া'],
            ['name' => 'Miapara', 'bn_name' => 'মিয়াপাড়া'],
            ['name' => 'Station Road', 'bn_name' => 'ঘোড়াশাল স্টেশন রোড'],
        ];
        foreach ($ghorashalVillages as $ghv) {
            Village::firstOrCreate(['union_id' => $ghorashal->id, 'name' => $ghv['name']], ['bn_name' => $ghv['bn_name']]);
        }

        // 5. Sample Land Listings with Real Union & Village linked
        $chamrabVillage = Village::where('union_id', $ghorashal->id)->where('name', 'Chamrab')->first();
        $charsindurBazarVillage = Village::where('union_id', $charsindur->id)->where('name', 'Charsindur Bazar')->first();
        $kajairVillage = Village::where('union_id', $danga->id)->where('name', 'Kajair')->first();
        $jinardiStationVillage = Village::where('union_id', $jinardi->id)->where('name', 'Jinardi Station')->first();
        $rampurVillage = Village::where('union_id', $gazaria->id)->where('name', 'Rampur')->first();

        $properties = [
            [
                'user_id' => $seller->id,
                'district_id' => $narsingdi->id,
                'upazila_id' => $palash->id,
                'union_id' => $ghorashal->id,
                'village_id' => $chamrabVillage?->id,
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
                'village_id' => $charsindurBazarVillage?->id,
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
                'village_id' => $kajairVillage?->id,
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
                'village_id' => $jinardiStationVillage?->id,
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
            [
                'user_id' => $seller->id,
                'district_id' => $narsingdi->id,
                'upazila_id' => $palash->id,
                'union_id' => $gazaria->id,
                'village_id' => $rampurVillage?->id,
                'mouza_area' => 'রামপুর, গজারিয়া',
                'title' => 'গজারিয়া রামপুর পাকা রাস্তার সাথে ৬ শতাংশ উর্বর কৃষি ও ভিটা জমি',
                'slug' => 'gazaria-rampur-6-decimal-land-'.Str::random(5),
                'description' => 'পলাশ উপজেলার গজারিয়া ইউনিয়নের রামপুর গ্রামে ১২ ফিট পাকা রাস্তার সংলগ্ন ৬ শতাংশ চমৎকার নিষ্কন্টক জমি। বাড়ি নির্মাণ কিংবা বাগান/কৃষি খামারের জন্য অতি উপযোগী। নিষ্কন্টক দলিল ও হালনাগাদ খাজনা পরিশোধিত।',
                'land_type' => 'residential',
                'land_size' => 6.00,
                'size_unit' => 'decimal',
                'price' => 2400000.00,
                'price_type' => 'total',
                'is_negotiable' => true,
                'road_width_feet' => 12,
                'road_type' => 'paved',
                'address' => 'রামপুর, গজারিয়া ইউনিয়ন, পলাশ, নরসিংদী',
                'khatian_type' => 'RS',
                'daag_no' => '৮৯০',
                'khatian_no' => '৫১২',
                'is_mutation_done' => true,
                'is_tax_updated' => true,
                'contact_number' => '01812345678',
                'whatsapp_number' => '01812345678',
                'status' => 'approved',
                'is_verified' => true,
                'is_featured' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80',
                'youtube_url' => null,
            ],
        ];

        foreach ($properties as $propData) {
            Property::create($propData);
        }
    }
}
