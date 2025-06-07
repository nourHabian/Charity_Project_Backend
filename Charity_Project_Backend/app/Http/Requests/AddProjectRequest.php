<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'user_id' => 'required_if:duration_type,تطوعي|integer|exists:types,id',
            'type_id' => 'required|integer|exists:types,id',
            'name' => 'required|string|max:200',
            'description' => 'required|string|max:200',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
            'total_amount' => 'required|string|max:200',
            'current_amount' => 'required|string|max:200',

            'priority' => ['nullable', 'string', Rule::in(['منخفض', 'متوسط', 'مرتفع', 'حرج'])],
            'duration_type' => ['required', 'string', Rule::in(['مؤقت', 'دائم', 'تطوعي', 'فردي'])],

            'location' => 'required_if:duration_type,تطوعي|string|max:200',
            'volunteer_hours' => 'required_if:duration_type,تطوعي|string|max:200',
            'required_tasks' => 'required_if:duration_type,تطوعي|string|max:200',
        ];
    }
}
