<?php
namespace App\Http\Request\Categorias;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoriasStoreRequest extends FormRequest {
    public function rules()
    {
        return [
            'categoria' => 'required|min:2|max:100',
        ];
    }

    public function messages()
    {
        return [
            'categoria.required' => 'O campo :attribute não pode ser vazio',
            'categoria.min' => 'O campo :attribute não aceita menos de :min caracteres',
            'categoria.max' => 'O campo :attribute tem o limite de :max caracteres',
        ];
    }

    public function withValidator($validator)
    {
        if($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'messagem' => 'Algum campo não foi preenchido de forma correta',
                'errors' => $validator->errors(),
            ], 400));
        }
    }
}