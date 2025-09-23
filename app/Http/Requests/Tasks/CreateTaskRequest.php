<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\ValidDueDate;
class CreateTaskRequest extends FormRequest
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
            'title' => 'required|max:100',
            'description' => 'nullable',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => ['nullable', new ValidDueDate()],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Title cannot exceed 100 characters',
            'assigned_to.required' => 'Assigned user is required',
            'assigned_to.exists' => 'Selected user does not exist',
        ];
    }
}

