<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        User::create([
            'first_name'   => 'standard',
            'last_name'    => 'user',
            'username'     => 'standardUser',
            'password'     => bcrypt('password'),
            'role'         => 'standard_user'
        ]);
        User::create([
            'first_name'   => 'Pro',
            'last_name'    => 'user',
            'username'     => 'proUser',
            'password'     => bcrypt('password'),
            'role'         => 'pro_user'
        ]);
        User::create([
            'first_name'   => 'engineer',
            'last_name'    => 'user',
            'username'     => 'engineerUser',
            'password'     => bcrypt('password'),
            'role'         => 'engineer'
        ]);
    }
}
