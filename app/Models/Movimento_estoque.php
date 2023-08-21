<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimento_estoque extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'produto_id', 'origem_id', 'destino_id', 'colaborador_id'];

    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'produto_id');
    }

    public function origem()
    {
        return $this->belongsTo(Setores::class, 'origem_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaboladores::class, 'colaborador_id');
    }
}