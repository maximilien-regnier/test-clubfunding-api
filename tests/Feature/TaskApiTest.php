<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_tasks_list()
    {
        $project = Project::factory()->create();
        Task::factory()->create(['project_id' => $project->id]);
        
        $response = $this->getJson('/api/tasks');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'status', 'project_id']
                     ]
                 ]);
    }

    public function test_can_create_task()
    {
        $project = Project::factory()->create();
        $taskData = [
            'title' => 'Nouvelle tâche',
            'status' => 'pending',
            'project_id' => $project->id
        ];
        
        $response = $this->postJson('/api/tasks', $taskData);
        
        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_can_filter_tasks_by_status()
    {
        $project = Project::factory()->create();
        Task::factory()->create(['status' => 'pending', 'project_id' => $project->id]);
        Task::factory()->create(['status' => 'completed', 'project_id' => $project->id]);
        
        $response = $this->getJson('/api/tasks?status=pending');
        
        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json('data')));
    }

    public function test_task_validation_works()
    {
        $response = $this->postJson('/api/tasks', []);
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'project_id']);
    }
}
