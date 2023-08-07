<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ColaboradorImport;
use App\Jobs\ProcessImportsColaborador;
use Illuminate\Support\Facades\Bus;
class ColaboradoresController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
  
   
    /**
    * @return \Illuminate\Support\Collection
    */
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