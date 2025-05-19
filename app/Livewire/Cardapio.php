<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Prato;
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

    public function mount()
    {
        $this->carregarCategorias();

        // Se existem categorias, selecionar a primeira como ativa
        if ($this->categorias->isNotEmpty()) {
            $this->categoriaAtiva = $this->categorias->first()->id;
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
        // Implementar lógica para adicionar ao pedido (a ser implementado futuramente)
        session()->flash('message', 'Prato adicionado ao pedido!');
        $this->pratoSelecionado = null;
    }

    public function render()
    {
        return view('livewire.cardapio');
    }
}
