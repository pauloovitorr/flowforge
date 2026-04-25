<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkflowActionsRequest extends FormRequest
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
            'workflow_id' => ['required', 'integer'],
            'type' => ['required', Rule::in(['email', 'api'])],
            'email_id' => ['required_if:type,email', 'nullable'],

            // Validação da API
            'url' => ['required_if:type,api', 'nullable', 'url'],
            'method' => ['required_if:type,api', 'nullable', 'string'],

            // Validação de Headers
            'headers_keys' => ['sometimes', 'array'],
            'headers_values' => ['sometimes', 'array'],
            'headers_keys.*' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    // Pega o índice atual (ex: 0 de headers_keys.0)
                    $index = explode('.', $attribute)[1];
                    $val = request("headers_values.{$index}");
                    if (! empty($value) && empty($val)) {
                        $fail("O valor para a chave de header '{$value}' é obrigatório.");
                    }
                },
            ],
            'headers_values.*' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $key = request("headers_keys.{$index}");
                    if (! empty($value) && empty($key)) {
                        $fail("A chave para o valor de header '{$value}' é obrigatória.");
                    }
                },
        ],

            // Validação do Body (Keys/Values)
            'keys' => ['sometimes', 'array'],
            'values' => ['sometimes', 'array'],
            'keys.*' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $val = request("values.{$index}");
                    if (! empty($value) && (is_null($val) || $val === '')) {
                        $fail("O valor para a chave '{$value}' não pode ser vazio.");
                    }
                },
        ],
            'values.*' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $key = request("keys.{$index}");
                    if (! empty($value) && (is_null($key) || $key === '')) {
                        $fail("A chave para o valor '{$value}' não pode ser vazia.");
                    }
                },
        ],
        ];
    }
}
