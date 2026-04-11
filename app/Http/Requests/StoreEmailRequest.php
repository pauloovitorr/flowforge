<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'body' => 'required|string|min:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do template é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'body.required' => 'O conteúdo do email (Body) é obrigatório.',
            'body.string' => 'O conteúdo deve ser um texto válido.',
            'body.min' => 'O conteúdo do email deve ter pelo menos :min caracteres (evite apenas tags vazias).',
        ];
    }
}
