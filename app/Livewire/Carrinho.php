<?php

namespace App\Livewire;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Carrinho extends Component
{
    public $itensCarrinho = [];
    public $valorTotal = 0;
    public $modalFinalizarPedido = false;
    public $modalRemoverItem = false;
    public $itemToRemove = null;
    public $modalLimparCarrinho = false;

    public function mount()
    {
        $this->carregarCarrinho();
    }

    public function carregarCarrinho()
    {
        if (!Auth::check()) {
            $this->itensCarrinho = [];
            $this->valorTotal = 0;
            return;
        }

        $this->itensCarrinho = Pedido::carrinho()
            ->porUsuario(Auth::id())
            ->with(['prato', 'prato.categoria'])
            ->orderBy('created_at', 'desc')
            ->get();

        $this->valorTotal = Pedido::valorTotalCarrinho(Auth::id());
    }

    public function aumentarQuantidade($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        if ($pedido && $pedido->id_user === Auth::id() && $pedido->status === 'carrinho') {
            $pedido->increment('qtd');
            $this->carregarCarrinho();
            session()->flash('message', 'Quantidade aumentada!');
        }
    }

    public function diminuirQuantidade($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        if ($pedido && $pedido->id_user === Auth::id() && $pedido->status === 'carrinho') {
            if ($pedido->qtd > 1) {
                $pedido->decrement('qtd');
                $this->carregarCarrinho();
                session()->flash('message', 'Quantidade diminuída!');
            } else {
                $this->confirmarRemoverItem($pedidoId);
            }
        }
    }

    public function confirmarRemoverItem($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        if ($pedido && $pedido->id_user === Auth::id() && $pedido->status === 'carrinho') {
            $this->itemToRemove = $pedidoId;
            $this->modalRemoverItem = true;
        }
    }

    public function fecharModalRemoverItem()
    {
        $this->modalRemoverItem = false;
        $this->itemToRemove = null;
    }

    public function removerItem()
    {
        if (!$this->itemToRemove) {
            return;
        }

        $pedido = Pedido::find($this->itemToRemove);
        if ($pedido && $pedido->id_user === Auth::id() && $pedido->status === 'carrinho') {
            $nomePrato = $pedido->prato->nome;
            $pedido->delete();
            $this->carregarCarrinho();
            $this->fecharModalRemoverItem();
            session()->flash('message', "'{$nomePrato}' foi removido do carrinho!");
        }
    }

    public function confirmarLimparCarrinho()
    {
        if ($this->itensCarrinho->isEmpty()) {
            session()->flash('error', 'Seu carrinho já está vazio!');
            return;
        }
        $this->modalLimparCarrinho = true;
    }

    public function fecharModalLimparCarrinho()
    {
        $this->modalLimparCarrinho = false;
    }

    public function limparCarrinho()
    {
        Pedido::carrinho()->porUsuario(Auth::id())->delete();
        $this->carregarCarrinho();
        $this->fecharModalLimparCarrinho();
        session()->flash('message', 'Carrinho limpo com sucesso!');
    }

    public function abrirModalFinalizarPedido()
    {
        if ($this->itensCarrinho->isEmpty()) {
            session()->flash('error', 'Seu carrinho está vazio!');
            return;
        }
        $this->modalFinalizarPedido = true;
    }

    public function fecharModalFinalizarPedido()
    {
        $this->modalFinalizarPedido = false;
    }

    public function finalizarPedido()
    {
        if ($this->itensCarrinho->isEmpty()) {
            session()->flash('error', 'Seu carrinho está vazio!');
            return;
        }

        $numeroPedido = Pedido::finalizarCarrinho(Auth::id());

        if ($numeroPedido) {
            $this->carregarCarrinho();
            $this->modalFinalizarPedido = false;

            session()->flash('message', "Pedido finalizado com sucesso! Número do pedido: {$numeroPedido}");

            // Redireciona para a página de pedidos
            return redirect()->route('pedidos.index');
        } else {
            session()->flash('error', 'Erro ao finalizar o pedido. Tente novamente.');
        }
    }

    public function voltarAoCardapio()
    {
        return redirect()->route('cardapio');
    }

    public function render()
    {
        return view('livewire.carrinho')
            ->title('Meu Carrinho');
    }
}
