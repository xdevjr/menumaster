<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Cria o usuário admin apenas se não existir
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
            ]);
        }

        // Execute os seeders criados
        $this->call([
            \Database\Seeders\CategoriaSeeder::class,
            \Database\Seeders\PratoSeeder::class,
            \Database\Seeders\PedidoSeeder::class,
        ]);
    }
}
