<?php

namespace App\Http\Controllers;

use App\Models\Movimento_estoque;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentoEstoqueController extends Controller
{
    private $movimento;
    private $produto;

    public function __construct(Movimento_estoque $movimento, Produtos $produto) {
        $this->movimento = $movimento;
    }

    public function index(Request $request)
    {
        try {
            $query = $this->movimento->with('produto', 'origem', 'colaborador')
            ->when($request->get('id'), function ($query) use ($request) {
                return $query->where('produto_id', '=' , $request->get('id'));
            })->when($request->get('page'), function ($query) use($request){
                    
                if($request->get('page') < 0){
                    return $query->get();
                }
                
                return $query->paginate(4);
            }, function ($query) {
                return $query->get();
            });

            return response()->json($query);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function store(Request $request) 
    {
        try {
            $query = $this->movimento->create([
                'descricao' => $request->get('descricao'),
                'produto_id' => $request->get('produto_id'),
                'origem_id' => $request->get('origem_id'),
                'destino_id' => $request->get('destino_id'),
            ]);

            return response()->json($query, 201);

        } catch (\Throwable $th) {
            return $th;
        }
    }
}
