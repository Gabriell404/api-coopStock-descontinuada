<?php

namespace App\Http\Controllers;

use App\Http\Resources\Perfil\PerfilCollectionResource;
use App\Models\Perfils;
use App\Models\Roles;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerfillController extends Controller
{
    public function listar()
    {
        try {
            return new PerfilCollectionResource(Perfils::paginate(10));
            
        } catch(Exception $e){
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            Perfils::create([
                'nome' => $request->get('nome'),
                'descricao' => $request->get('descricao'),
            ]);

            DB::commit();

            return response()->json([
                'error' => false,
                'messagem' => 'Perfil criado'
        ]);

        } catch(Exception $e){
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function permissao(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $perfil = Perfils::findOrFail($id);
            $permissao = Roles::findOrFail($request->get('permissao'));
            $message = '';

            if(User::existePermissao($permissao->id, $perfil->id)){
                $perfil->removerPermissao($permissao);
                $message = $permissao->nome. ' removida com sucesso';
            }else {
                $perfil->adicionarPermissao($permissao);
                $message = $permissao->nome. ' adicionada com sucesso';
            }

            DB::commit();

            return response()->json([
                'error' => false,
                'messagem' => $message,
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function listarPermissao(Request $request, $id)
    {
        try {

            $perfil = Perfils::findOrFail($id);

            return response()->json([
               'data' => $perfil->permissoes
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
