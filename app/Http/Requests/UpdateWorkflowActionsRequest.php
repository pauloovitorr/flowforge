<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkflowActionsRequest extends FormRequest
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

            // Body
            'body_keys' => ['sometimes', 'array'],
            'body_values' => ['sometimes', 'array'],

            'body_keys.*' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    // Ex: body_keys.0 -> extrai o 0
                    $index = explode('.', $attribute)[1];
                    // Busca o valor correspondente no array de values
                    $val = request("body_values.{$index}");

                    if (! empty($value) && (is_null($val) || $val === '')) {
                        $fail("O valor para a chave '{$value}' não pode ser vazio.");
                    }
                },
            ],

            'body_values.*' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    // Ex: body_values.0 -> extrai o 0
                    $index = explode('.', $attribute)[1];
                    // Busca a chave correspondente no array de keys
                    $key = request("body_keys.{$index}");

                    if (! empty($value) && (is_null($key) || $key === '')) {
                        $fail("A chave para o valor '{$value}' não pode ser vazia.");
                    }
                },
            ],

        ];
    }
}
