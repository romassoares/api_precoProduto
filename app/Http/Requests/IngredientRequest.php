<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|max:100|min:3',
            'und' => 'required',
            'amount' => 'required|numeric',
            'price' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'description.required' => 'esse campo é obrigatório',
            'description.min' => 'campo deve ter no minimo 5 caracteres',
            'description.min' => 'campo deve ter no máximo 100 caracteres',
            'amount.required' => 'esse campo é obrigatório',
            'amount.numeric' => 'campo deve ser numérico',
            'price.required' => 'esse campo é obrigatório',
            'und.required' => 'esse campo é obrigatório',
        ];
    }
}
