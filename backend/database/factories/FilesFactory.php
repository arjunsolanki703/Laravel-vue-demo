<?php

namespace Database\Factories;

use App\Models;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Files;

class FilesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Files::class;



    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $images_destination = public_path('files');
        return [
            "user_id" => 1,
            "comment_id" => 1, 
            "path" => $images_destination,
            "filename" => 'nature.jpg'
        ];

    }
}