<?php

namespace App\Http\Controllers;

use App\Models\Movimento_estoque;
use Illuminate\Http\Request;

class MovimentoEstoqueController extends Controller
{
    private $movimento;

    public function __construct(Movimento_estoque $movimento) {
        $this->movimento = $movimento;
    }

    public function index(Request $request)
    {
        try {
            $query = $this->movimento->when($request->get('id'), function ($query) use ($request) {
                return $query->where('id', '=', $request->get('id'));
            })->get();

            return response()->json($query);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
