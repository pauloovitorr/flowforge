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
            'workflow_id' => [
                'required',
                'integer',
                Rule::exists('workflows', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],

            'email_id' => [
                'nullable',
                'integer',
                Rule::exists('emails', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],

        ];
    }
}
