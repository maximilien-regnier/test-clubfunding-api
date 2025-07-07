<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendOverdueTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-overdue-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for pending tasks older than 7 days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Searching overdue tasks...');
        
        $overdueTasks = Task::with('project')
            ->where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->get();
        
        if ($overdueTasks->isEmpty()) {
            $this->info('No overdue pending tasks found.');
            return Command::SUCCESS;
        }
        
        $this->info("Found {$overdueTasks->count()} overdue pending task(s).");
        
        foreach ($overdueTasks as $task) {
            $daysOverdue = Carbon::now()->diffInDays($task->created_at);
            
            // Email Simulation
            Log::info('Overdue Task Reminder', [
                'task_id' => $task->id,
                'task_title' => $task->title,
                'project_name' => $task->project->name,
                'days_overdue' => $daysOverdue,
                'created_at' => $task->created_at->format('Y-m-d H:i:s'),
                'message' => "Reminder: Task '{$task->title}' in project '{$task->project->name}' has been pending for {$daysOverdue} days."
            ]);
            
            $this->line("- Task: {$task->title} (Project: {$task->project->name}) - {$daysOverdue} days overdue");
        }
        
        $this->info("Reminder emails simulated for {$overdueTasks->count()} overdue task(s).");
        
        return Command::SUCCESS;
    }
}
