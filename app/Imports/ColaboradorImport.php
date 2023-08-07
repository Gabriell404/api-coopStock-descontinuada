<?php
namespace App\Imports;

use App\Models\Colaboladores;
use Maatwebsite\Excel\Concerns\ToModel;

class ColaboradorImport implements  ToModel {
    public function model(array $row)
    {
        return new Colaboladores([
            'data_admissao' => $row[0],
            'cpf' => $row[1],
            'nome' => $row[2],
            'funcao' => $row[3],
        ]);
    }
}