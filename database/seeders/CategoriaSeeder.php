<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Entradas'],
            ['nome' => 'Pratos Principais'],
            ['nome' => 'Sobremesas'],
            ['nome' => 'Bebidas'],
            ['nome' => 'Acompanhamentos'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate(
                ['nome' => $categoria['nome']],
                $categoria
            );
        }
    }
}
