<?php

namespace Database\Seeders;

use App\Modules\Task\Models\Task;
use App\Modules\Task\Enums\TaskStatus;
use App\Modules\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('Nenhum usuário encontrado. Execute o UserSeeder primeiro.');
            return;
        }

        foreach ($users as $user) {
            Task::create([
                'title' => 'Estudar Laravel',
                'description' => 'Revisar conceitos de Laravel e Inertia.js',
                'status' => TaskStatus::Open,
                'due_date' => now()->addDays(3),
                'user_id' => $user->id,
            ]);

            Task::create([
                'title' => 'Implementar testes',
                'description' => 'Criar testes para o projeto',
                'status' => TaskStatus::Open,
                'due_date' => now()->addDays(7),
                'user_id' => $user->id,
            ]);

            Task::create([
                'title' => 'Configurar ambiente',
                'description' => 'Instalar e configurar Docker',
                'status' => TaskStatus::Done,
                'due_date' => now()->subDays(5),
                'user_id' => $user->id,
            ]);
        }

        $this->command->info('Tarefas criadas com sucesso!');
    }
}
