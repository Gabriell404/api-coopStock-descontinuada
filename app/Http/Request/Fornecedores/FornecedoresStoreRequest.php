<?php
namespace App\Http\Request\Fornecedores;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FornecedoresStoreRequest extends FormRequest {
    public function rules() 
    {
        return [
            'endereco' => 'required|min:5|max:100',
            'cnpj' => 'required|min:15|max:15',
            'fornecedor_nome' => 'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            'endereco.required' => 'O campo :attribute não pode ser vazio',
            'endereco.min' => 'O campo :attribute não aceita menos de :min caracteres',
            'endereco.max' => 'O campo :attribute tem o limite de :max caracteres',
            'cnpj.required' => 'O campo :attribute não pode ser vazio',
            'cnpj.min' => 'O campo :attribute não aceita menos de :min caracteres',
            'cnpj.max' => 'O campo :attribute tem o limite de :max caracteres',
            'fornecedor_nome.required' => 'O campo :attribute não pode ser vazio',
            'fornecedor_nome.min' => 'O campo :attribute não aceita menos de :min caracteres',
            'fornecedor_nome.max' => 'O campo :attribute tem o limite de :max caracteres',
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