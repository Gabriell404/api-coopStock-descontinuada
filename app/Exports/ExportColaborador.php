<?php
namespace App\Exports;

use App\Models\Colaboladores;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportColaborador implements FromCollection, WithHeadings {

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        return Colaboladores::get(['data_admissao', 'cpf', 'nome', 'funcao']);
    }

    public function headings(): array
    {
        return ['Data de Admissão', 'CPF', 'Nome', 'Função'];
    }
}
