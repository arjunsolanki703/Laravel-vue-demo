<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Projects;
use App\Models\User;
use JWTAuth;
use App\Traits\AttachesJWT;
use Carbon\Carbon;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;
    use AttachesJWT;

    public function testRetrieveAllProjectSuccessfully()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');
        $project = Projects::factory()->create([
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
        ]);

        $res = $this->json('GET', 'api/get-project', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Record found successfully..!",
                "data" => [[
                    "user_id" => 1,
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
                    "status" => "in_process",
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "user_name" => null
                ]]
            ]);
    }

    public function testProjectAddSuccessfully()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');

        $payload = [
            "user_id" => 2,
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
        ];

        $this->json('POST', 'api/add-project', $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Data stored successfully..!",
                "data" => [
                    "user_id" => 2,
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
                    "status" => "in_process",
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                ]
            ]);
    }

    public function testRetrieveProjectSuccessfully()
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

        $this->json('GET', 'api/get-project/' . $project->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Data Found",
                "data" => [
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
                    "status" => "in_process",
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z")
                ]
            ]);
    }

    public function testProjectUpdatedSuccessfully()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');
        $project = Projects::factory()->create([
            "user_id" => 4,
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


        $payload = [
            "user_id" => 4,
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
        ];

        $this->json('PUT', 'api/update-project/' . $project->id , $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Record updated successfully",
                "data" => [
                    "user_id" => 4,
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
                    "status" => "in_process",
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z")
                ]
            ]);
    }

    public function testDeleteProject()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');
        $project = Projects::factory()->create([
            "user_id" => 5,
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

        $this->json('DELETE', 'api/delete-project/' . $project->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testProjectUpdateStatusSuccessfully()
    {
        $user = User::factory()->create();
        $this->loginAs($user, 'api');
        $project = Projects::factory()->create([
            "user_id" => 5,
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


        $payload = [
            "status" => "assigned_to_engineer"
        ];

        $this->json('PUT', 'api/change-project-status/' . $project->id , $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
                "message" => "Project completed successfully",
                "data" => [
                    "user_id" => 5,
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
                    "status" => "assigned_to_engineer",
                    "created_at" => gmDate("Y-m-d\TH:i:s.000000\Z"),
                    "updated_at" => gmDate("Y-m-d\TH:i:s.000000\Z")
                ]
            ]);
    }
}
