<?php
namespace App\Http\Resources\Produto;

use App\Services\ResponseService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource 
{
    private $config;

    public function __construct($resource, $config = array())
    {
        parent::__construct($resource);
        $this->config = $config;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'produto' => $this->produto,
            'numero_de_serie' => $this->numero_de_serie,
            'detalhes' => $this->detalhes,
            'valor' => $this->valor,
            'numero_de_patrimonio' => $this->numero_de_patrimonio,
            'estado' => $this->estado,
            'fornecedor_id' => $this->fornecedor_id,
            'categoria_id' => $this->categoria_id,
            'colaborador_id' => $this->colaborador_id,
        ];
    }

     /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */

    public function with($request)
    {
        return ResponseService::default($this->config, $this->id);
    }

     /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request
     * @param  \Illuminate\Http\Response
     * @return void
     */

    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }
}