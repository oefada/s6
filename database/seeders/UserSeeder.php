<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Password'),
            'status' => 'active',
            'type' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Vendor 1',
            'email' => 'vendor1@gmail.com',
            'password' => Hash::make('Password'),
            'status' => 'active',
            'type' => 'vendor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Vendor 2',
            'email' => 'vendor2@gmail.com',
            'password' => Hash::make('Password'),
            'status' => 'active',
            'type' => 'vendor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('Password'),
            'status' => 'active',
            'type' => 'user',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        User::where('email', 'user@gmail.com')->first()->addresses()->save(
            new Address([
                'first_name' => 'John',
                'last_name' => 'Doe',
                'line_1' => '123 Main St',
                'city' => 'Miami',
                'state' => 'FL',
                'country' => 'US',
                'zip' => '33186',
            ])
        );
    }
}
