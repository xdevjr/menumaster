<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    protected $fillable = ['id_user', 'id_prato', 'qtd', 'status', 'numero_pedido', 'finalizado_em'];

    protected $casts = [
        'qtd' => 'integer',
        'finalizado_em' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function prato(): BelongsTo
    {
        return $this->belongsTo(Prato::class, 'id_prato');
    }

    /**
     * Calcula o valor total do pedido
     */
    public function getValorTotalAttribute(): float
    {
        return $this->prato->preco * $this->qtd;
    }

    /**
     * Formata o valor total para exibição
     */
    public function getValorTotalFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->valor_total, 2, ',', '.');
    }

    /**
     * Scope para filtrar pedidos por usuário
     */
    public function scopePorUsuario($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Scope para filtrar pedidos por data
     */
    public function scopePorData($query, $dataInicio, $dataFim = null)
    {
        if ($dataFim) {
            return $query->whereBetween('created_at', [$dataInicio, $dataFim]);
        }

        return $query->whereDate('created_at', $dataInicio);
    }

    /**
     * Scope para carrinho (pedidos não finalizados)
     */
    public function scopeCarrinho($query)
    {
        return $query->where('status', 'carrinho');
    }

    /**
     * Scope para pedidos finalizados
     */
    public function scopeFinalizados($query)
    {
        return $query->where('status', 'finalizado');
    }

    /**
     * Gera um número único para o pedido
     */
    public static function gerarNumeroPedido()
    {
        do {
            $numero = 'PED' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('numero_pedido', $numero)->exists());

        return $numero;
    }

    /**
     * Finaliza o carrinho do usuário
     */
    public static function finalizarCarrinho($userId)
    {
        $itensCarrinho = self::carrinho()->porUsuario($userId)->get();

        if ($itensCarrinho->isEmpty()) {
            return false;
        }

        $numeroPedido = self::gerarNumeroPedido();
        $agora = now();

        foreach ($itensCarrinho as $item) {
            $item->update([
                'status' => 'finalizado',
                'numero_pedido' => $numeroPedido,
                'finalizado_em' => $agora,
            ]);
        }

        return $numeroPedido;
    }

    /**
     * Calcula o valor total do carrinho do usuário
     */
    public static function valorTotalCarrinho($userId)
    {
        return self::carrinho()
            ->porUsuario($userId)
            ->with('prato')
            ->get()
            ->sum(function ($pedido) {
                return $pedido->prato->preco * $pedido->qtd;
            });
    }

    /**
     * Conta itens no carrinho do usuário
     */
    public static function contarItensCarrinho($userId)
    {
        return self::carrinho()->porUsuario($userId)->sum('qtd');
    }
}
