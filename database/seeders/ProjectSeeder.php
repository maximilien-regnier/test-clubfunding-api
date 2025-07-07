<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'name' => 'Développement Site Web E-commerce',
            'created_at' => now()->subDays(15),
            'updated_at' => now()->subDays(5)
        ]);

        Project::create([
            'name' => 'Application Mobile de Gestion',
            'created_at' => now()->subDays(20),
            'updated_at' => now()->subDays(3)
        ]);
    }
}
