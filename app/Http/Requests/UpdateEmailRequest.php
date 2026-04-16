<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
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
            'status' => 'required|string|in:active,inactive',
            'body' => 'required|string|min:20',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do template é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',

            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser "active" ou "inactive".',

            'body.required' => 'O conteúdo do email (Body) é obrigatório.',
            'body.string' => 'O conteúdo deve ser um texto válido.',
            'body.min' => 'O conteúdo do email deve ter pelo menos :min caracteres.',
            'user_id.required' => 'O identificador do usuário é obrigatório.',
            'user_id.exists' => 'O usuário informado não é válido.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()?->id,
        ]);
    }
}
