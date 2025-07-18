<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Task::truncate();
        \App\Models\Project::truncate();

        $this->call(ProjectSeeder::class);

        $this->call(TaskSeeder::class);
    }
}
