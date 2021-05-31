<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 50; $i++) {
            DB::table('projects')->insert([
                'user_id' => $i,
                'engineer_user_id' => rand(11,99),
                'address' => Str::random(10),
                'city' => Str::random(10),
                'state' => Str::random(10),
                'zip' => Str::random(6),
                'county' => Str::random(10),
                'project_name' => Str::random(10),
                'client_po' => Str::random(10),
                'project_number' => Str::random(10),
                'project_notes' => Str::random(10),
                'type' => 'full_structural',
                'status' => 'assigned_to_engineer',
                'created_at' => now(),
                'updated_at' => now(),
                ]);
        }
    }
}
