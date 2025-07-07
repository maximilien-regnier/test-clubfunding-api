<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = Project::all();
        
        if ($projects->isEmpty()) {
            $this->command->error('Aucun projet trouvé. Veuillez d\'abord exécuter ProjectSeeder.');
            return;
        }

        $ecommerceProject = $projects->where('name', 'Développement Site Web E-commerce')->first();
        if ($ecommerceProject) {
            Task::create([
                'title' => 'Analyser les besoins fonctionnels',
                'status' => 'completed',
                'project_id' => $ecommerceProject->id,
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(8)
            ]);
            
            Task::create([
                'title' => 'Développer l\'interface utilisateur',
                'status' => 'pending',
                'project_id' => $ecommerceProject->id,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(2)
            ]);
            
            Task::create([
                'title' => 'Intégrer le système de paiement',
                'status' => 'pending',
                'project_id' => $ecommerceProject->id,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(1)
            ]);
        }

        $mobileProject = $projects->where('name', 'Application Mobile de Gestion')->first();
        if ($mobileProject) {
            Task::create([
                'title' => 'Créer les maquettes UI/UX',
                'status' => 'completed',
                'project_id' => $mobileProject->id,
                'created_at' => now()->subDays(18),
                'updated_at' => now()->subDays(15)
            ]);
            
            Task::create([
                'title' => 'Implémenter l\'API backend',
                'status' => 'pending',
                'project_id' => $mobileProject->id,
                'created_at' => now()->subDays(14),
                'updated_at' => now()->subDays(3)
            ]);
            
            Task::create([
                'title' => 'Développer les tests unitaires',
                'status' => 'pending',
                'project_id' => $mobileProject->id,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(1)
            ]);
        }
    }
}
