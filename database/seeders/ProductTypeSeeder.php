<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            'name' => 'Fine Arts',
            'vendor_id' => Vendor::where('business_name', 'Marco Fine Arts')->first()->id,
            'created_at' => Carbon::now(),
        ]);

        DB::table('product_types')->insert([
            'name' => 'T Shirts',
            'vendor_id' => Vendor::where('business_name', 'DreamJunction')->first()->id,
            'created_at' => Carbon::now(),
        ]);
    }
}
