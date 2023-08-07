<?php

namespace App\Http\Controllers;

use App\Http\Request\Categorias\CategoriasStoreRequest;
use App\Models\Categorias;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Exception;

class CategoriasController extends Controller
{
    private $categorias;

    public function __construct(Categorias $categorias)
    {
        $this->categorias = $categorias;
    }

    public function index(Request $request)
    {
        try {
            $query = $this->categorias->when($request->get('categoria'), function ($query) use ($request) {
                return $query->where('nome_categoria', '=', $request->get('categoria'));
            })
            ->when($request->get('id'), function ($query) use ($request) {
                return $query->where('id', '=', $request->get('id'));
            })->get();

            return response()->json($query);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store(CategoriasStoreRequest $request)
    {
        $categoria = $this->categorias->create([
            'nome_categoria' => $request->get('categoria')
        ]);

        return response()->json($categoria, 201);
    }

    public function update(CategoriasStoreRequest $request,$id)
    {
        try {
            $query = $this->categorias->find($id);

            if(!$query) 
            {
                return response()->json('Não foi encontrado nenhum registro.');
            }

            $query->update([
                'nome_categoria' => $request->get('categoria'),
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function destroy($id)
    {
        try {
            $query = $this->categorias->find($id);

            if(!$query) {
                return response()->json('Não foi encontrado nenhum registro impossibilitando a exclusão.');
            }

            $query->delete();

        } catch (\Throwable $th) {
            return $th;
        }
    }
}