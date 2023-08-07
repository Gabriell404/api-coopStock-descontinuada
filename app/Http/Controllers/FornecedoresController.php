<?php

namespace App\Http\Controllers;

use App\Http\Request\Fornecedores\FornecedoresStoreRequest;

use App\Models\Fornecedores;
use Illuminate\Http\Request;

class FornecedoresController extends Controller
{
    private $fornecedores;

    public function __construct(Fornecedores $fornecedores)
    {
        $this->fornecedores = $fornecedores;
    }

    public function index(Request $request)
    {
        try {
            $query = $this->fornecedores->when($request->get('cnpj'), function ($query) use ($request){
                return $query->where('cnpj', '=', $request->get('cnpj'));
            })
            ->when($request->get('fornecedor_nome'), function ($query) use ($request){
                return $query->where('fornecedor_nome', '=', $request->get('fornecedor_nome'));
            })->get();

            return response()->json($query);

        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function store(FornecedoresStoreRequest $request)
    {
        try {
            $fornecedor = $this->fornecedores->create([
                'endereco' => $request->get('endereco'),
                'cnpj' => $request->get('cnpj'),
                'fornecedor_nome' => $request->get('fornecedor_nome'),
            ]);

            return response()->json($fornecedor, 201);

        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $query = $this->fornecedores->find($id);

            if(!$query) {
                return response()->json('Não foi encontrado nenhum registro.');
            }

            $query->update([
                'endereco' => $request->get('endereco'),
                'cnpj' => $request->get('cnpj'),
                'fornecedor_nome' => $request->get('fornecedor_nome'), 
            ]);


        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function destroy($id)
    {
        try {
            $query = $this->fornecedores->find($id);

            if(!$query){
                return response()->json('Não foi encontrado nenhum registro.');
            }

            $query->delete();
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
