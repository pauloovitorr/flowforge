<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEventRequest extends FormRequest
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
            'event_name' => 'required|string|max:255',
            'payload' => 'required|array'
        ];
    }

    public function messages(): array
    {
        return [
            'event_name.required' => 'O nome do evento é obrigatório.',
            'event_name.string' => 'O nome do evento deve ser um texto.',
            'payload.required' => 'Os dados do evento (payload) são obrigatórios.',
            'payload.array' => 'O payload deve ser um conjunto de dados válido (formato JSON).',
        ];
    }


    protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(
        response()->json([
            'status' => 'error',
            'message' => 'Erro de validação',
            'errors' => $validator->errors()
        ], 422, [], JSON_UNESCAPED_UNICODE)
    );
}

}
