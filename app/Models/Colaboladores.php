<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaboladores extends Model
{
    use HasFactory;

    protected $fillable = ['data_admissao', 'cpf', 'nome', 'funcao'];
}
