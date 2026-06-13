<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            
            'name' => 'required|string|max:255'
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do projeto é obrigatório.',
            'name.string'   => 'O nome deve ser um texto válido.',
            'name.max'      => 'O nome não pode ter mais de 255 caracteres.'
        ];
    }
}
