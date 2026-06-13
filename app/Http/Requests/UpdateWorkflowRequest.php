<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkflowRequest extends FormRequest
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
            'project_id' => ['required', 'integer',
                Rule::exists('projects', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'user_id' => 'required|integer|exists:users,id',
            'trigger_event' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da automação é obrigatório.',
            'project_id.required' => 'Você precisa selecionar um projeto.',
            'project_id.exists' => 'O projeto selecionado não foi encontrado em nossa base.',
            'user_id.required' => 'O identificador do usuário é obrigatório.',
            'user_id.exists' => 'O usuário informado não é válido.',
            'trigger_event.required' => 'O evento de gatilho (trigger) deve ser definido.',
            'status.required' => 'O status da automação deve ser informado.',
            'status.in' => 'O status deve ser "active" (ativo) ou "inactive" (inativo).',
            'description.max' => 'A descrição não pode ultrapassar 1000 caracteres.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()?->id,
        ]);
    }
}
