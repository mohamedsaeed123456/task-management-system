<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\ValidDueDate;

class UpdateTaskRequest extends FormRequest
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
        $user = $this->user();
        
        if ($user->role === 'user') {
            return [
                'status' => 'required|in:pending,completed,canceled'
            ];
        } else {
            return [
                'title' => 'required|max:100',
                'description' => 'sometimes',
                'assigned_to' => 'required|exists:users,id',
                'due_date' => ['sometimes', new ValidDueDate()],
                'status' => 'sometimes|in:pending,completed,canceled',
            ];
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.max' => 'Title cannot exceed 100 characters',
            'assigned_to.exists' => 'Selected user does not exist',
            'due_date.date' => 'Due date must be a valid date format (Y-m-d) or (Y/m/d)',
            'status.in' => 'Status must be pending, completed, or canceled',
        ];
    }
}

