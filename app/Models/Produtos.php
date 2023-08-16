<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;

    protected $fillable = ['produto', 
                            'numero_de_serie', 
                            'detalhes', 
                            'valor', 
                            'numero_de_patrimonio', 
                            'estado', 
                            'fornecedor_id', 
                            'categoria_id',
                            'setor_id',
                        ];

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedor_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaboladores::class, 'colaborador_id');
    }

    public function setor_responsavel() {
        return $this->belongsTo(Setores::class, 'setor_id');
    }
}
