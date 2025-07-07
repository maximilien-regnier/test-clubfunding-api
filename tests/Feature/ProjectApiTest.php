<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_projects_list()
    {
        Project::factory()->create(['name' => 'Test Project']);
        
        $response = $this->getJson('/api/projects');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'created_at', 'updated_at']
                     ]
                 ]);
    }

    public function test_can_create_project()
    {
        $projectData = ['name' => 'Nouveau Projet'];
        
        $response = $this->postJson('/api/projects', $projectData);
        
        $response->assertStatus(201);
        $this->assertDatabaseHas('projects', $projectData);
    }

    public function test_project_name_is_required()
    {
        $response = $this->postJson('/api/projects', []);
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    public function test_can_filter_projects_by_name()
    {
        Project::factory()->create(['name' => 'E-commerce']);
        Project::factory()->create(['name' => 'Mobile App']);
        
        $response = $this->getJson('/api/projects?name=commerce');
        
        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json('data')));
    }
}
