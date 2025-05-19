<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\Prato;
use App\Models\User;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica se existem usuários e pratos
        $users = User::all();
        $pratos = Prato::all();

        // Se não houver usuários ou pratos, não cria pedidos
        if ($users->isEmpty() || $pratos->isEmpty()) {
            return;
        }

        // Cria alguns pedidos de exemplo
        $admin = User::where('email', 'admin@admin.com')->first();

        if ($admin) {
            // Pega alguns pratos aleatórios
            $pratosAleatorios = $pratos->random(min(3, $pratos->count()));

            foreach ($pratosAleatorios as $prato) {
                Pedido::create([
                    'id_user' => $admin->id,
                    'id_prato' => $prato->id,
                    'qtd' => rand(1, 3)
                ]);
            }
        }
    }
}
