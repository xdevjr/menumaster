<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Prato;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cardapio extends Component
{
    public $categorias;
    public $categoriaAtiva;
    public $pratoSelecionado;
    public $termoBusca = '';
    public $filtroPrecoDe;
    public $filtroPrecoPara;
    public $modoBusca = false;
    public $pratosEncontrados = [];
    public $totalPedidosUsuario = 0;

    public function mount()
    {
        $this->carregarCategorias();

        // Se existem categorias, selecionar a primeira como ativa
        if ($this->categorias->isNotEmpty()) {
            $this->categoriaAtiva = $this->categorias->first()->id;
        }

        // Carrega o total de pedidos do usuário logado
        $this->atualizarTotalPedidos();
    }

    public function atualizarTotalPedidos()
    {
        if (Auth::check()) {
            $this->totalPedidosUsuario = \App\Models\Pedido::contarItensCarrinho(Auth::id());
        }
    }

    protected function carregarCategorias()
    {
        $this->categorias = Categoria::with([
            'pratos' => function ($query) {
                if (!empty($this->termoBusca)) {
                    $query->where('nome', 'like', '%' . $this->termoBusca . '%')
                        ->orWhere('desc', 'like', '%' . $this->termoBusca . '%');
                }

                if (!empty($this->filtroPrecoDe)) {
                    $query->where('preco', '>=', $this->filtroPrecoDe);
                }

                if (!empty($this->filtroPrecoPara)) {
                    $query->where('preco', '<=', $this->filtroPrecoPara);
                }
            }
        ])->get();
    }

    public function selecionarCategoria($categoriaId)
    {
        $this->categoriaAtiva = $categoriaId;
    }

    public function selecionarPrato($pratoId)
    {
        $this->pratoSelecionado = Prato::findOrFail($pratoId);
    }

    public function fecharDetalhesPrato()
    {
        $this->pratoSelecionado = null;
    }

    public function buscarPratos()
    {
        // Se temos algum termo de busca ou filtro de preço, ativar o modo busca
        if (!empty($this->termoBusca) || !empty($this->filtroPrecoDe) || !empty($this->filtroPrecoPara)) {
            $this->modoBusca = true;

            // Busca diretamente na tabela de pratos sem separar por categorias
            $query = Prato::with('categoria')->orderBy('nome');

            if (!empty($this->termoBusca)) {
                $query->where(function ($q) {
                    $q->where('nome', 'like', '%' . $this->termoBusca . '%')
                        ->orWhere('desc', 'like', '%' . $this->termoBusca . '%');
                });
            }

            if (!empty($this->filtroPrecoDe)) {
                $query->where('preco', '>=', $this->filtroPrecoDe);
            }

            if (!empty($this->filtroPrecoPara)) {
                $query->where('preco', '<=', $this->filtroPrecoPara);
            }

            $this->pratosEncontrados = $query->get();
        } else {
            $this->modoBusca = false;
            $this->carregarCategorias();
        }
    }

    public function limparFiltros()
    {
        $this->termoBusca = '';
        $this->filtroPrecoDe = null;
        $this->filtroPrecoPara = null;
        $this->modoBusca = false;
        $this->pratosEncontrados = [];
        $this->carregarCategorias();
    }

    public function adicionarAoPedido($pratoId)
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            session()->flash('error', 'Você precisa estar logado para fazer um pedido.');
            return;
        }

        // Verifica se o prato existe
        $prato = Prato::find($pratoId);
        if (!$prato) {
            session()->flash('error', 'Prato não encontrado.');
            return;
        }

        // Verifica se já existe um item deste prato no carrinho do usuário
        $pedidoExistente = \App\Models\Pedido::carrinho()
            ->where('id_user', Auth::id())
            ->where('id_prato', $pratoId)
            ->first();

        if ($pedidoExistente) {
            // Se já existe, incrementa a quantidade
            $pedidoExistente->increment('qtd');
            session()->flash('message', "Quantidade do prato '{$prato->nome}' foi aumentada no seu carrinho!");
        } else {
            // Cria um novo item no carrinho
            \App\Models\Pedido::create([
                'id_user' => Auth::id(),
                'id_prato' => $pratoId,
                'qtd' => 1,
                'status' => 'carrinho',
            ]);
            session()->flash('message', "Prato '{$prato->nome}' foi adicionado ao seu carrinho!");
        }

        $this->pratoSelecionado = null;
        $this->atualizarTotalPedidos(); // Atualiza o contador após adicionar
    }

    public function render()
    {
        return view('livewire.cardapio')
            ->title('Cardápio');
    }
}
