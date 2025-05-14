<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    protected $fillable = ['id_user', 'id_prato', 'qtd'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function prato(): BelongsTo
    {
        return $this->belongsTo(Prato::class, 'id_prato');
    }
}
