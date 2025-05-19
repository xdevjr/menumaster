<?php

namespace Database\Seeders;

use App\Models\Prato;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class PratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Certifique-se de que as categorias existem
        $entradas = Categoria::where('nome', 'Entradas')->first()?->id;
        $pratosPrincipais = Categoria::where('nome', 'Pratos Principais')->first()?->id;
        $sobremesas = Categoria::where('nome', 'Sobremesas')->first()?->id;
        $bebidas = Categoria::where('nome', 'Bebidas')->first()?->id;
        $acompanhamentos = Categoria::where('nome', 'Acompanhamentos')->first()?->id;
        $pratos = [
            // Entradas
            [
                'nome' => 'Bruschetta',
                'desc' => 'Fatias de pão italiano grelhado com tomate, alho, manjericão e azeite',
                'preco' => 18.90,
                'id_categoria' => $entradas,
            ],
            [
                'nome' => 'Carpaccio',
                'desc' => 'Finas fatias de carne crua com molho especial',
                'preco' => 32.50,
                'id_categoria' => $entradas,
            ],
            [
                'nome' => 'Camarão Empanado',
                'desc' => 'Camarões empanados e fritos servidos com molho tártaro',
                'preco' => 42.90,
                'id_categoria' => $entradas,
            ],
            [
                'nome' => 'Croquete de Bacalhau',
                'desc' => '6 unidades de croquetes de bacalhau servidos com molho aioli',
                'preco' => 36.50,
                'id_categoria' => $entradas,
            ],
            [
                'nome' => 'Queijo Coalho',
                'desc' => 'Espetinhos de queijo coalho grelhado com melaço',
                'preco' => 28.90,
                'id_categoria' => $entradas,
            ],
            [
                'nome' => 'Bolinho de Feijoada',
                'desc' => '8 bolinhos com recheio de feijoada servidos com molho de pimenta',
                'preco' => 32.90,
                'id_categoria' => $entradas,
            ],

            // Pratos Principais
            [
                'nome' => 'Filé Mignon',
                'desc' => 'Filé mignon grelhado com molho de vinho tinto',
                'preco' => 78.90,
                'id_categoria' => $pratosPrincipais,
            ],
            [
                'nome' => 'Salmão Grelhado',
                'desc' => 'Filé de salmão grelhado com legumes',
                'preco' => 65.90,
                'id_categoria' => $pratosPrincipais,
            ],
            [
                'nome' => 'Feijoada Completa',
                'desc' => 'Feijoada tradicional com arroz, couve, laranja e farofa',
                'preco' => 59.90,
                'id_categoria' => $pratosPrincipais,
            ],
            [
                'nome' => 'Picanha ao Ponto',
                'desc' => 'Picanha grelhada servida com vinagrete, farofa e batatas rústicas',
                'preco' => 89.90,
                'id_categoria' => $pratosPrincipais,
            ],
            [
                'nome' => 'Risoto de Camarão',
                'desc' => 'Risoto cremoso com camarões frescos e limão siciliano',
                'preco' => 72.90,
                'id_categoria' => $pratosPrincipais,
            ],
            [
                'nome' => 'Lasanha à Bolonhesa',
                'desc' => 'Lasanha com molho à bolonhesa, presunto e queijo',
                'preco' => 52.90,
                'id_categoria' => $pratosPrincipais,
            ],
            [
                'nome' => 'Peixe à Moqueca',
                'desc' => 'Moqueca de peixe com arroz, pirão e farofa',
                'preco' => 68.90,
                'id_categoria' => $pratosPrincipais,
            ],
            [
                'nome' => 'Frango Parmegiana',
                'desc' => 'Filé de frango empanado com molho de tomate, presunto e queijo',
                'preco' => 54.90,
                'id_categoria' => $pratosPrincipais,
            ],

            // Sobremesas
            [
                'nome' => 'Petit Gateau',
                'desc' => 'Bolo de chocolate com recheio cremoso e sorvete de creme',
                'preco' => 24.90,
                'id_categoria' => $sobremesas,
            ],
            [
                'nome' => 'Pudim de Leite',
                'desc' => 'Pudim de leite condensado com calda de caramelo',
                'preco' => 18.90,
                'id_categoria' => $sobremesas,
            ],
            [
                'nome' => 'Mousse de Maracujá',
                'desc' => 'Mousse de maracujá com calda de frutas vermelhas',
                'preco' => 19.90,
                'id_categoria' => $sobremesas,
            ],
            [
                'nome' => 'Sorvete Gourmet',
                'desc' => '3 bolas de sorvete gourmet (diversos sabores)',
                'preco' => 21.90,
                'id_categoria' => $sobremesas,
            ],
            [
                'nome' => 'Cheesecake',
                'desc' => 'Cheesecake com cobertura de frutas vermelhas',
                'preco' => 26.90,
                'id_categoria' => $sobremesas,
            ],
            [
                'nome' => 'Brownie com Sorvete',
                'desc' => 'Brownie de chocolate com nozes e sorvete de creme',
                'preco' => 23.90,
                'id_categoria' => $sobremesas,
            ],

            // Bebidas
            [
                'nome' => 'Vinho Tinto',
                'desc' => 'Taça de vinho tinto seco',
                'preco' => 22.00,
                'id_categoria' => $bebidas,
            ],
            [
                'nome' => 'Vinho Branco',
                'desc' => 'Taça de vinho branco suave',
                'preco' => 20.00,
                'id_categoria' => $bebidas,
            ],
            [
                'nome' => 'Refrigerante',
                'desc' => 'Lata 350ml (diversos sabores)',
                'preco' => 7.90,
                'id_categoria' => $bebidas,
            ],
            [
                'nome' => 'Água Mineral',
                'desc' => 'Com ou sem gás (500ml)',
                'preco' => 5.90,
                'id_categoria' => $bebidas,
            ],
            [
                'nome' => 'Suco Natural',
                'desc' => 'Diversos sabores (laranja, abacaxi, maracujá, limão)',
                'preco' => 12.90,
                'id_categoria' => $bebidas,
            ],
            [
                'nome' => 'Caipirinha',
                'desc' => 'Cachaça, limão e açúcar',
                'preco' => 24.90,
                'id_categoria' => $bebidas,
            ],
            [
                'nome' => 'Cerveja Artesanal',
                'desc' => 'IPA, Pilsen, Stout, Weiss (garrafa 500ml)',
                'preco' => 28.90,
                'id_categoria' => $bebidas,
            ],
            [
                'nome' => 'Café Espresso',
                'desc' => 'Café espresso italiano',
                'preco' => 6.90,
                'id_categoria' => $bebidas,
            ],

            // Acompanhamentos
            [
                'nome' => 'Batata Frita',
                'desc' => 'Porção de batatas fritas crocantes',
                'preco' => 15.90,
                'id_categoria' => $acompanhamentos,
            ],
            [
                'nome' => 'Arroz Branco',
                'desc' => 'Porção de arroz branco soltinho',
                'preco' => 9.90,
                'id_categoria' => $acompanhamentos,
            ],
            [
                'nome' => 'Farofa Especial',
                'desc' => 'Farofa de mandioca com bacon e ovos',
                'preco' => 12.90,
                'id_categoria' => $acompanhamentos,
            ],
            [
                'nome' => 'Legumes Salteados',
                'desc' => 'Mix de legumes frescos salteados na manteiga',
                'preco' => 18.90,
                'id_categoria' => $acompanhamentos,
            ],
            [
                'nome' => 'Polenta Frita',
                'desc' => 'Palitos de polenta frita crocante',
                'preco' => 14.90,
                'id_categoria' => $acompanhamentos,
            ],
            [
                'nome' => 'Purê de Batatas',
                'desc' => 'Purê de batatas cremoso com manteiga',
                'preco' => 12.90,
                'id_categoria' => $acompanhamentos,
            ],
        ];

        foreach ($pratos as $prato) {
            Prato::updateOrCreate(
                ['nome' => $prato['nome']],
                $prato
            );
        }
    }
}
