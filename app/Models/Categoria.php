<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = ['nome'];

    public function pratos(): HasMany
    {
        return $this->hasMany(Prato::class, 'id_categoria');
    }
}
