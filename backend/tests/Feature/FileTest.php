<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Traits\AttachesJWT;
use App\Models\User;
use App\Models\Files;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    use AttachesJWT;

    public function testFileAddSuccessfully()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');

        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.pdf');
        $images_destination = public_path('files');

        $payload = [
            "user_id" => $user->id,
            "comment_id" => 1,
            "path" => 'http://localhost:8000/files/nature.jpg',
            "filename" => $file,
        ];
        $filename = md5(rand('111111', '999999')) . '.' . $file->getClientOriginalExtension();

        $res = $this->json('POST', 'api/add-file', $payload, ['Accept' => 'application/json']);
            $res->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Data Found",
                "data" => [
                    "user_id" => $user->id,
                    "comment_id" => 1,
                    "path" => $images_destination.'/'.$res->original['data']['filename'],
                    "filename" => $res->original['data']['filename'],
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                ]
            ]);
    }

}
