<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class AddCharityProjectRequest extends FormRequest
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
            'photo' => 'required|file|mimes:png,jpg,jpeg,gif|max:2048',
            'total_amount' => 'required|numeric|min:10',
            'current_amount' => 'required|numeric|min:0',
            'priority' => ['required', 'string', Rule::in(['منخفض', 'متوسط', 'مرتفع', 'حرج'])],
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $total_amount = $this->input('total_amount');
            $current_amount = $this->input('current_amount');

            // تحقق من شرط المبلغ المدفوع لا يتجاوز المبلغ المستهدف
            if (!is_null($total_amount) && !is_null($current_amount) && $current_amount > $total_amount) {
                $validator->errors()->add('current_amount', 'المبلغ المدفوع من رصيد الجمعية يجب أن لا يتجاوز المبلغ المستهدف.');
            }
        });
    }



}
