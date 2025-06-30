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
            'contact_number'=>'required|string|min:10',
            'age'=>'required|integer|max:50',
            'purpose_of_volunteering'=>'required|string',
            'current_location'=>'required|string',
            'volunteering_hours'=>'required|integer|',
            'gender'=>['required','string',Rule::in(['ذكر','أنثى'])],
            'volunteering_domain'=>['required','string',Rule::in(['ميداني','عن بعد','صحي','تعليمي'])],
            'education'=>['required' , 'string',Rule::in(['جامعي','ثانوي','دراسات عليا'])],

            
        ];
    }
}
