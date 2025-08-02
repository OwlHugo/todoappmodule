<?php

namespace Database\Seeders;

use App\Modules\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@todo.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@todo.com'],
            [
                'name' => 'Usuário Teste',
                'password' => Hash::make('password'),
            ]
        );

        if (User::count() < 5) {
            User::create([
                'name' => 'Usuário Teste 1',
                'email' => 'teste1@todo.com',
                'password' => Hash::make('password'),
            ]);
            
            User::create([
                'name' => 'Usuário Teste 2',
                'email' => 'teste2@todo.com',
                'password' => Hash::make('password'),
            ]);
            
            User::create([
                'name' => 'Usuário Teste 3',
                'email' => 'teste3@todo.com',
                'password' => Hash::make('password'),
            ]);
        }

        $this->command->info('Usuários criados com sucesso!');
    }
}
