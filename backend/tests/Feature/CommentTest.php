<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Traits\AttachesJWT;
use App\Models\Comments;
use App\Models\Projects;
use App\Models\User;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use AttachesJWT;
    use RefreshDatabase;

    public function testCommentAddSuccessfully()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');

        $payload = [
            "user_id" => $user->id,
            "project_id" => 1,
            "content" => 'Test message'
        ];

        $this->json('POST', 'api/add-comment', $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Data stored successfully..!",
                "data" => [
                    "user_id" => $user->id,
                    "comment_id" => 1,
                    "path" => "http://127.0.0.1:8000/public/files/",
                    "filename" => "[]",
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                ]
            ]);
    }

    public function testGetCommentSuccessfully()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');

        $comment = Comments::factory()->create([
            "user_id" => $user->id,
            "project_id" => 1,
            "content" => 'Test message'
        ]);

        $res = $this->json('GET', 'api/get-comment', ['Accept' => 'application/json']);
            $res->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Record found successfully..!",
                "data" => [[
                    "id" => 2,
                    "project_id" => 1,
                    "user_id" => 2,
                    "content" => "Test message",
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "user_name" => null
                ]]
            ]);
    }

    public function testRetrieveCommentSuccessfully()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');
        $project = Projects::factory()->create([
            "user_id" => 3,
            "engineer_user_id" => 1,
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
        ]);
        $comment = Comments::factory()->create([
            "user_id" => $user->id,
            "project_id" => $project->id,
            "content" => 'Test message'
        ]);

        $this->json('GET', 'api/get-comment-by-project-id/' . $project->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Record Found successfully",
                "data" => [[
                    "project_id" => 1,
                    "user_id" => $user->id,
                    "content" => "Test message",
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "user_name" => "admin"
                ]]
            ]);
    }

    public function testDeleteComment()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');

        $comment = Comments::factory()->create([
            "user_id" => $user->id,
            "project_id" => 1,
            "content" => 'Test message'
        ]);

        $this->json('DELETE', 'api/delete-comment/' . $comment->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
