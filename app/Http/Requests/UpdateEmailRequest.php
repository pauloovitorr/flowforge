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
            'subject' => 'required|string|max:255',
            'body' => 'required|string|min:20',
            'user_id' => 'required|integer|exists:users,id',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'O assunto do e-mail é obrigatório.',
            'subject.string' => 'O assunto deve ser um texto válido.',
            'subject.max' => 'O assunto não pode ultrapassar 255 caracteres.',

            'body.required' => 'O conteúdo do e-mail (Body) é obrigatório.',
            'body.string' => 'O conteúdo deve ser um texto válido.',
            'body.min' => 'O conteúdo do e-mail deve ter pelo menos :min caracteres.',

            'user_id.required' => 'O identificador do usuário é obrigatório.',
            'user_id.exists' => 'O usuário informado não é válido.',

            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status selecionado deve ser "active" ou "inactive".',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()?->id,
        ]);
    }
}
