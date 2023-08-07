<?php
namespace App\Http\Request\Setores;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SetoresStoreRequest extends FormRequest {
    public function rules()
    {
        return [
            'nome' => 'required|max:100',
            'cidade' => 'required|max:50',
            'estado' => 'required|max:2',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo :attribute não pode ser vazio',
            'nome.max' => 'O campo :attribute pode conter no maximo :max caracteres',
            'cidade.required' => 'O campo :attribute não pode ser vazio',
            'cidade.max' => 'O campo :attribute pode conter no maximo :max caracteres',
            'estado.required' => 'O campo :attribute não pode ser vazio',
            'estado.max' => 'O campo :attribute pode conter no maximo :max caracteres',
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