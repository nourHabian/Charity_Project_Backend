<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddVolunteerRequest extends FormRequest
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
            'user_id' => 'nullable|integer|exists:users,id',
            'project_id' => 'nullable|integer|exists:users,id',
            'phone_number' => 'required|string|min:10',
            'age' => 'required|integer|min:18|max:50',
            'place_of_residence' => 'required|string',
            'gender' => ['required', 'string', Rule::in(['ذكر', 'أنثى'])],
            'your_last_educational_qualification' => ['required', 'string', Rule::in(['معهد متوسط /دبلوم', 'طالب جامعي', ' بكالوريوس', 'ماجستير'])],
            'your_studying_domain' => 'required|string',
            'volunteering_hours' => 'required|integer|',
            'purpose_of_volunteering' => 'required|string',







        ];
    }
}
