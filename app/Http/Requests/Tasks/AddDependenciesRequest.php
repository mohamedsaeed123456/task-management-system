<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AddDependenciesRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'dependencies' => 'required|array',
            'dependencies.*' => 'exists:tasks,id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'dependencies.required' => 'Dependencies are required',
            'dependencies.array' => 'Dependencies must be an array',
            'dependencies.*.exists' => 'One or more selected tasks do not exist',
        ];
    }
}

