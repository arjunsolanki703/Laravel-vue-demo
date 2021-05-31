<?php

namespace Database\Factories;

use App\Models;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Projects;

class ProjectsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Projects::class;



    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => "1",
            "engineer_user_id" => "1",
            "address" => "Adajan",
            "city" => "Surat",
            "state" => "Gujarat",
            "zip" => "395001",
            "county" => "India",
            "project_name" => "Project 001",
            "client_po" => "Test",
            "project_number" => "Pro-001",
            "project_notes" => "Notes",
            "type" => "electrical",
            "status" => "in_process"
        ];

    }
}