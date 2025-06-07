<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:200',
            'description' => 'sometimes|string|max:200',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg,gip|max:2048',
            'total_amount' => 'sometimes|string|max:200',
            'current_amount' => 'sometimes|string|max:200',
            'status' => 'sometimes|string|max:200',
            'priority' => 'sometimes|string|max:200',
            'duration_type' => 'sometimes|string|max:200',
            'location' => 'sometimes|string|max:200',
            'volunteer_hours' => 'sometimes|string|max:200',
            'required_tasks' => 'sometimes|string|max:200',
            'project_type' => 'sometimes|string|max:200'
        ];
    }
}
