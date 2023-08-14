<?php

namespace App\Http\Controllers;

use App\Http\Request\Produtos\ProdutosStoreRequest;
use App\Models\Produtos;

use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    private $produtos;

    public function __construct(Produtos $produtos) {
        $this->produtos = $produtos;
    }

    public function index(Request $request)
    {
        try {
            $query = $this->produtos->with('categoria', 'fornecedor', 'colaborador', 'setor_responsavel')
            ->when($request->get('id'), function ($query) use ($request){
                return $query->where('id', '=', $request->get('id'));
            })
            ->when($request->get('produto'), function ($query) use ($request) {
                return $query->where('produto', '=', $request->get('produto'));
            })
            ->when($request->get('numero_de_serie'), function ($query) use ($request) {
                return $query->where('numero_de_serie', '=', $request->get('numero_de_serie'));
            })
            ->when($request->get('numero_de_patrimonio'), function ($query) use ($request) {
                return $query->get('numero_de_patrimonio', '=', $request->get('numero_de_patrimonio'));
            })->get();

            return response()->json($query);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store(ProdutosStoreRequest $request) 
    {
        try {
            $produto = $this->produtos->create([
                'produto' => $request->get('produto'),
                'numero_de_serie' => $request->get('numero_de_serie'),
                'detalhes' => $request->get('detalhes'),
                'valor' => $request->get('valor'),
                'numero_de_patrimonio' => $request->get('numero_de_patrimonio'),
                'estado' => $request->get('estado'),
                'fornecedor_id' => $request->get('fornecedor_id'),
                'categoria_id' => $request->get('categoria_id'),
                'setor_id' => $request->get('setor_id'),
            ]);

            return response()->json($produto);
        } catch (\Throwable $th) {
            return response($th);
        }
    }

    public function update(Request $request)
    {
        try {
            $produto = $this->produtos::find($request->id);
            $produto->update($request->all());

            return response()->json([
                "success" => true,
                "messagem" => 'O produto foi editado com sucesso!'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "error" => $th
            ], 500);
        }
    }
}
