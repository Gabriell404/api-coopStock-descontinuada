<?php

namespace App\Http\Controllers;

use App\Models\Setores;
use Illuminate\Http\Request;
use App\Http\Request\Setores\SetoresStoreRequest;


class SetoresController extends Controller
{
    private $setores;

    public function __construct(Setores $setores)
    {
        $this->setores = $setores;
    }

    public function index(Request $request)
    {
        try {
            $query = $this->setores->when($request->get('id'), function ($query) use ($request){
                return $query->where('id', '=', $request->get('id'));
            })
            ->when($request->get('nome'), function ($query) use ($request){
                return $query->where('nome', '=', $request->get('nome'));
            })
            ->when($request->get('cidade'), function ($query) use ($request) {
                return $query->where('cidade', '=', $request->get('cidade'));
            })->get();

            return response()->json($query);

        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function store(SetoresStoreRequest $request)
    {
        try {
            $setores = $this->setores->create([
                'nome' => $request->get('nome'),
                'cidade' => $request->get('cidade'),
                'estado' => $request->get('estado'),
            ]);

            return response()->json($setores, 201);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function destroy($id)
    {
        try {
            $query = $this->setores->find($id);

            if(!$query) {
                return response()->json('Não foi encontrado nenhum registro impossibilitando a exclusão.');
            }
            $query->delete();

        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
