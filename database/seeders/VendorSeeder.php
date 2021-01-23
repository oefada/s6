<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vendors')->insert([
            'business_name' => 'DreamJunction',
            'user_id' => User::where('email', 'vendor1@gmail.com')->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('vendors')->insert([
            'business_name' => 'Marco Fine Arts',
            'business_name' => 'Marco Fine Arts',
            'user_id' => User::where('email', 'vendor2@gmail.com')->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
