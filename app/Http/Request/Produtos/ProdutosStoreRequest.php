<?php 
namespace App\Http\Request\Produtos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProdutosStoreRequest extends FormRequest {
    public function rules()
    {
        return [
            'produto' => 'required|max:100',
            'estado' => 'required|max:30',
            'fornecedor_id' => 'required',
            'categoria_id' =>  'required',
            'colaborador_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'produto.required' => 'O campo :attribute não pode ser vazio',
            'produto.max' => 'O campo :attribute aceita no maximo :max caracteres',
            'estado.required' => 'O campo :attribute não pode ser vazio',
            'estado.max' => 'O campo :attribute aceita no maximo :max caracteres',
            'fornecedor_id.required' => 'O campo :attribute não pode ser vazio',
            'categoria_id.required' => 'O campo :attribute não pode ser vazio',
            'colaborador_id.required' => 'O campo :attribute não pode ser vazio'
        ];
    }

    public function withValidator($validator)
    {
        if($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'messagem' => 'Algum campo não foi preenchido de forma correta',
                'error' => $validator->errors(),
            ], 400));
        }
    }
}