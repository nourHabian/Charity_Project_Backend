<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProjectRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'description' => 'required|string|max:200',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg,gip|max:2048',
            'total_amount' => 'required|string|max:200',
            'current_amount' => 'required|string|max:200',
            'status' => 'required|string|max:200',
            'priority' => 'nullable|string|max:200',
            'duration_type' => 'required|string|max:200',
            'location' => 'required|string|max:200',
            'volunteer_hours' => 'required|string|max:200',
            'required_tasks' => 'required|string|max:200',
            'project_type' => 'required|string|max:200'
        ];
    }
}
