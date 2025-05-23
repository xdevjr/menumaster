<?php

namespace App\Livewire\Pedidos;

use App\Models\Pedido;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class PedidoIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $userFilter = '';
    public $dateFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'userFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingUserFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->userFilter = '';
        $this->dateFilter = '';
        $this->resetPage();
    }

    public function voltarAoCardapio()
    {
        return redirect()->route('cardapio');
    }

    public function verCarrinho()
    {
        return redirect()->route('carrinho.index');
    }
    public function render()
    {
        $pedidosQuery = Pedido::finalizados()->with(['user', 'prato.categoria']);

        // Filtro por busca (nome do usuário, nome do prato ou número do pedido)
        if (!empty($this->search)) {
            $pedidosQuery->where(function ($query) {
                $query->whereHas('user', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('prato', function ($subQuery) {
                    $subQuery->where('nome', 'like', '%' . $this->search . '%');
                })->orWhere('numero_pedido', 'like', '%' . $this->search . '%');
            });
        }        // Filtro por usuário
        if (!empty($this->userFilter)) {
            $pedidosQuery->where('id_user', $this->userFilter);
        }

        // Filtro por data
        if (!empty($this->dateFilter)) {
            $pedidosQuery->whereDate('finalizado_em', $this->dateFilter);
        }

        $pedidos = $pedidosQuery->orderBy('finalizado_em', 'desc')->get();

        // Agrupa pedidos por número do pedido
        $pedidosAgrupados = $pedidos->groupBy('numero_pedido');

        return view('livewire.pedidos.pedido-index', [
            'pedidosAgrupados' => $pedidosAgrupados,
            'users' => User::orderBy('name')->get(),
        ])->title('Pedidos Finalizados');
    }
}
