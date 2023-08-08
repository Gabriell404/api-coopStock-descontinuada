<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ColaboradorImport;
use App\Jobs\ProcessImportsColaborador;
use App\Models\Colaboladores;
use Illuminate\Support\Facades\Bus;
class ColaboradoresController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
  
    /**
    * @return \Illuminate\Support\Collection
    */

    private $colaboradores;

    public function __construct(Colaboladores $colaboladores)
    {
        $this->colaboradores = $colaboladores;
    }

    public function index(Request $request) 
    {
        $query = $this->colaboradores->when($request->get('id'), function ($query) use ($request) {
            return $query->where('id', '=', $request->get('id'));
        })
        ->when($request->get('cpf'), function($query) use ($request) {
            return $query->where('cpf', '=', $request->get('cpf'));
        })
        ->when($request->get('funcao'), function($query) use ($request) {
            return $query->where('funcao', '=', $request->get('funcao'));
        })->get();

        return response()->json($query);
    }
    
    public function importar(Request $request) 
    {
        try {
            Excel::import(new ColaboradorImport, $request->file('arquivo')->store('temp'));
            return back();
        } catch (\Throwable $th) {
            return $th;
        }
    }
}