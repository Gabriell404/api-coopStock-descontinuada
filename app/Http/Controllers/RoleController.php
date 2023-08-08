<?php

namespace App\Http\Controllers;

use App\Http\Resources\Roles\RolesCollectionResource;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;
use Exception;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    

    public function listar()
    {
        try {
            return new RolesCollectionResource(Roles::paginate(10));
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

            Roles::create([
                'nome' => $request->get('nome'),
                'descricao' => $request->get('descricao'),
            ]);

            DB::commit();

            return response()->json([
                'error' => false,
                'messagem' => 'Regra criada com sucesso!'
            ], 200);

        } catch(Exception $e){
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
