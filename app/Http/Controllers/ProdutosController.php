<?php

namespace App\Http\Controllers;

use App\Http\Request\Produtos\ProdutosStoreRequest;
use App\Models\Movimento_estoque;
use App\Models\Produtos;
use App\Models\Setores;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    private $produtos;
    private $movimentoEstoque;
    private $setor;
    private $movimentoProduto;

    public function __construct(Produtos $produtos, Movimento_estoque $movimentoEstoque, Setores $setor) {
        $this->produtos = $produtos;
        $this->movimentoEstoque = $movimentoEstoque;
        $this->setor = $setor;
    }

    public function index(Request $request)
    {
        try {
                $query = $this->produtos->with('categoria', 'fornecedor', 'colaborador', 'setorResponsavel')
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
                })
                ->when($request->get('page'), function ($query) use($request){
                    
                    if($request->get('page') < 0){
                        return $query->get();
                    }

                    return $query->paginate(8);


                }, function ($query){
                    return $query->get();
                });

                return response()->json($query);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store(ProdutosStoreRequest $request) 
    {
        try {
            // Tratando o valor monetario 
            $valorString = $request->get('valor');
            $valorString = str_replace(',', '.', $valorString); 
            $valorFloat = (float) $valorString; 

            $produto = $this->produtos->create([
                'produto' => $request->get('produto'),
                'numero_de_serie' => $request->get('numero_de_serie'),
                'detalhes' => $request->get('detalhes'),
                'valor' => $valorFloat,
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

    public function patch(Request $request)
    {
        try {
            $produto = $this->produtos::find($request->id);

            if(!$produto) {
                return response()->json([
                    'erro' => true,
                    'messagem' => 'Nenhum item foi encontrado'
                ]);
            }

            // Criação do historico de movimento
            $queryMovimentoEstoque = $this->movimentoEstoque->create([
                'descricao' => 'Movimento de estoque',
                'produto_id' => $produto->id,
                'origem_id' => 1,
                'destino_id' => 1,
                'colaborador_id' => $request->colaborador_id,
            ]);

            $produto->update([
                'colaborador_id' => $request->colaborador_id,
                'estado' => 'alocado',
            ]);
            
            // $produto->colaborador_id = $request->colaborador_id;
            $produto->save();
            return response()->json($queryMovimentoEstoque);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}