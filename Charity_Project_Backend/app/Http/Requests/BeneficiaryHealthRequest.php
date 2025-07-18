<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BeneficiaryHealthRequest extends FormRequest
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
            'full_name' => 'required|string|max:100',
            'age' => 'required|integer|min:18|max:100',
            'phone_number' => 'required|string|max:15',
            'gender' => ['required', 'string', Rule::in(['ذكر', 'أنثى'])],
            'marital_status' => ['required', 'string', Rule::in(['أعزب', 'متزوج', 'مطلق', 'أرمل'])],
            'number_of_kids' => 'required|integer|min:0|max:20',
            'kids_description' => 'nullable|string|max:1000',
            'governorate' => ['required', 'string', Rule::in(['دمشق', 'ريف دمشق', 'حماة', 'حمص', 'حلب', 'اللاذقية', 'طرطوس', 'درعا', 'السويداء', 'دير الزور', 'الحسكة', 'ادلب', 'القنيطرة', 'الرقة'])],
            'home_address' => 'required|string|max:255',
            'monthly_income' => 'required|numeric|min:0',
            'current_job' => 'required|string|max:100',
            'monthly_income_source' => ['required', 'string', Rule::in(['لا يوجد دخل', 'راتب تقاعدي', 'مساعدات من أقارب', 'مساعدات من جمعيات', 'عمل'])],
          
          
            'description' => 'required|string|max:1000',
            'severity_level' => ['required', 'string', Rule::in(['منخفض', 'متوسط', 'مرتفع', 'حرج'])],
            'expected_cost' => 'nullable|numeric|min:1',
            'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }
}
