<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddVolunteerProjectRequest extends FormRequest
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
            'type_id' => 'required|string|exists:types,name',
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'location' => 'nullable|string|max:200',
            'volunteer_hours' => 'required|string|max:200',
            'required_tasks' => 'required|string|max:200',
            'total_amount' => 'required|integer|min:1'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $location = $this->input('location');
            $type_id = $this->input('type_id');

            if (!is_null($type_id) && $type_id !== 'عن بعد' && (is_null($location) || $location == '')) {
                $validator->errors()->add('location', 'يجب إدخال الموقع في حال لم يكن نوع المشروع (عن بعد)');
            }

            if (!is_null($type_id) && $type_id === 'عن بعد' && !is_null($location)) {
                $validator->errors()->add('location', 'الرجاء عدم إدخال موقع في حال كان نوع المشروع (عن بعد)');
            }
        });
    }
}
