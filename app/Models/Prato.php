<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prato extends Model
{
    protected $fillable = ['nome', 'desc', 'preco', 'id_categoria'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'id_prato');
    }
}
