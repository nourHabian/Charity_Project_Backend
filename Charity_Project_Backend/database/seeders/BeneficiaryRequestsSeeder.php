<?php

namespace Database\Seeders;

use App\Models\BeneficiaryRequest;
use App\Models\RequestedSupply;
use App\Models\Supply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeneficiaryRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beneficiaryRequests = [

            //صحي

            [
                'user_id' => 4,
                'type_id' => 1,
                'full_name' => ' أحمد',
                'phone_number' => '0933041122',
                'gender' => 'ذكر',
                'age' => 40,
                'marital_status' => 'متزوج',
                'number_of_kids' => 3,
                'governorate' => 'دمشق',
                'kids_description' => 'ثلاثة أطفال في المدرسة',
                'home_address' => 'برزة، دمشق',
                'monthly_income' => 150000,
                'current_job' => 'عامل يومي',
                'monthly_income_source' => 'عمل خاص',
                'number_of_needy' => 5,
                'expected_cost' => 800000,
                'description' => 'عملية جراحية عاجلة للقلب',
                'severity_level' => 'حرج',
                'document_path' => null,
                'current_housing_condition' => null,
                'needed_housing_help' => null,
                'status' => 'معلق',
            ],


            [
                'user_id' => 4,
                'type_id' => 1,
                'full_name' => ' حسان',
                'phone_number' => '0983001122',
                'gender' => 'ذكر',
                'age' => 40,
                'marital_status' => 'متزوج',
                'number_of_kids' => 3,
                'governorate' => 'دمشق',
                'kids_description' => 'ثلاثة أطفال في المدرسة',
                'home_address' => 'برزة، دمشق',
                'monthly_income' => 150000,
                'current_job' => 'عامل يومي',
                'monthly_income_source' => 'عمل خاص',
                'number_of_needy' => 5,
                'expected_cost' => 800000,
                'description' => 'عملية جراحية عاجلة للقلب',
                'severity_level' => 'حرج',
                'document_path' => null,
                'current_housing_condition' => 'ملك',
                'needed_housing_help' => null,
                'status' => 'معلق',
            ],


            //تعليمي
            [
                'user_id' => 5,
                'type_id' => 2,
                'full_name' => 'رامي يوسف',
                'phone_number' => '0937441122',
                'gender' => 'ذكر',
                'age' => 19,
                'marital_status' => 'أعزب',
                'number_of_kids' => 2,
                'governorate' => 'حلب',
                'kids_description' => 'طفلان أحدهما في الابتدائي والآخر ثانوي',
                'home_address' => 'حي الحمدانية، حلب',
                'monthly_income' => 0,
                'current_job' => 'لا يوجد',
                'monthly_income_source' => 'لا يوجد',
                'number_of_needy' => 1,
                'expected_cost' => 300000,
                'description' => 'مصاريف جامعة (أقساط ومستلزمات دراسية)',
                'document_path' => null,
                'current_housing_condition' => 'ملك',
                'needed_housing_help' => null,
                'status' => 'معلق',
            ],
            [
                'user_id' => 4,
                'type_id' => 2,
                'full_name' => 'يوسف',
                'phone_number' => '0932141122',
                'gender' => 'ذكر',
                'age' => 19,
                'marital_status' => 'أعزب',
                'number_of_kids' => 0,
                'governorate' => 'حلب',
                'kids_description' => null,
                'home_address' => 'حي الحمدانية، حلب',
                'monthly_income' => 0,
                'current_job' => 'طالب جامعي',
                'monthly_income_source' => 'لا يوجد',
                'number_of_needy' => 1,
                'expected_cost' => 300000,
                'description' => 'مصاريف جامعة (أقساط ومستلزمات دراسية)',
                'document_path' => null,
                'current_housing_condition' => 'أجار',
                'needed_housing_help' => null,
                'status' => 'معلق',
            ],






            //سكني
            [
                'user_id' => 5,
                'type_id' => 3,
                'full_name' => 'سعاد محمد',
                'phone_number' => '0933067788',
                'gender' => 'أنثى',
                'age' => 35,
                'marital_status' => 'أرمل',
                'number_of_kids' => 2,
                'governorate' => 'ريف دمشق',
                'kids_description' => 'طفلين في الابتدائي',
                'home_address' => 'دوما، ريف دمشق',
                'monthly_income' => 100000,
                'current_job' => 'بدون عمل',
                'monthly_income_source' => 'معونة أهلية',
                'number_of_needy' => 3,
                'expected_cost' => 500000,
                'description' => 'مساعدة إيجار منزل',
                'document_path' => null,
                'current_housing_condition' => 'أجار',
                'needed_housing_help' => 'تأمين سكن',
                'status' => 'معلق',
            ],



            [
                'user_id' => 5,
                'type_id' => 3,
                'full_name' => 'علياء احمد',
                'phone_number' => '0973667788',
                'gender' => 'أنثى',
                'age' => 35,
                'marital_status' => 'أرمل',
                'number_of_kids' => 2,
                'governorate' => 'ريف دمشق',
                'kids_description' => 'طفلين في الابتدائي',
                'home_address' => 'دوما، ريف دمشق',
                'monthly_income' => 100000,
                'current_job' => 'بدون عمل',
                'monthly_income_source' => 'معونة أهلية',
                'number_of_needy' => 3,
                'expected_cost' => 500000,
                'description' => 'مساعدة إيجار منزل',
                'document_path' => null,
                'current_housing_condition' => 'ملك',
                'needed_housing_help' => 'تأمين سكن',
                'status' => 'مرفوض',
            ],

            [
                'user_id' => 5,
                'type_id' => 3,
                'full_name' => 'سناء درويش',
                'phone_number' => '0944856677',
                'gender' => 'أنثى',
                'age' => 42,
                'marital_status' => 'أرمل',
                'number_of_kids' => 4,
                'governorate' => 'حمص',
                'kids_description' => '4 أطفال بحاجة إلى مأوى',
                'home_address' => 'الوعر، حمص',
                'monthly_income' => 90000,
                'current_job' => 'تعمل خياطة في المنزل',
                'monthly_income_source' => 'عمل جزئي',
                'number_of_needy' => 5,
                'expected_cost' => 700000,
                'description' => 'دفع إيجار منزل وتكاليف تجهيزات أساسية',
                'document_path' => null,
                'current_housing_condition' => 'أجار',
                'needed_housing_help' => 'تأمين سكن',
                'status' => 'مقبول',
            ],
            //غذائي
            [
                'user_id' => 5,
                'type_id' => 4,
                'full_name' => 'أبو خالد',
                'phone_number' => '0935103456',
                'gender' => 'ذكر',
                'age' => 55,
                'marital_status' => 'متزوج',
                'number_of_kids' => 6,
                'governorate' => 'درعا',
                'kids_description' => '6 أطفال، بعضهم يعاني من سوء تغذية',
                'home_address' => 'درعا البلد، درعا',
                'monthly_income' => 70000,
                'current_job' => 'عامل بناء متقطع',
                'monthly_income_source' => 'أجر يومي متقطع',
                'number_of_needy' => 8,
                'expected_cost' => 400000,
                'description' => 'حاجة ماسة لسلة غذائية تكفي لشهرين',
                'document_path' => null,
                'current_housing_condition' => 'ملك',
                'needed_housing_help' => null,
                'status' => 'معلق',
            ],

            [
                'user_id' => 5,
                'type_id' => 4,
                'full_name' => 'علاء ',
                'phone_number' => '0937123456',
                'gender' => 'ذكر',
                'age' => 55,
                'marital_status' => 'متزوج',
                'number_of_kids' => 6,
                'governorate' => 'درعا',
                'kids_description' => '6 أطفال، بعضهم يعاني من سوء تغذية',
                'home_address' => 'درعا البلد، درعا',
                'monthly_income' => 70000,
                'current_job' => 'عامل بناء متقطع',
                'monthly_income_source' => 'أجر يومي متقطع',
                'number_of_needy' => 8,
                'expected_cost' => 400000,
                'description' => 'حاجة ماسة لسلة غذائية تكفي لشهرين',
                'document_path' => null,
                'current_housing_condition' => 'ملك',
                'needed_housing_help' => null,
                'status' => 'مرفوض',
            ]






        ];

        foreach ($beneficiaryRequests as $beneficiaryRequest) {
            if (!array_key_exists('severity_level', $beneficiaryRequest)) {
                $beneficiaryRequest['severity_level'] = 'متوسط';
            }
            BeneficiaryRequest::create([
                'user_id' => $beneficiaryRequest['user_id'],
                'type_id' => $beneficiaryRequest['type_id'],
                'full_name' => $beneficiaryRequest['full_name'],
                'phone_number' => $beneficiaryRequest['phone_number'],
                'gender' => $beneficiaryRequest['gender'],
                'age' => $beneficiaryRequest['age'],
                'marital_status' => $beneficiaryRequest['marital_status'],
                'number_of_kids' => $beneficiaryRequest['number_of_kids'],
                'governorate' => $beneficiaryRequest['governorate'],
                'kids_description' => $beneficiaryRequest['kids_description'],
                'home_address' => $beneficiaryRequest['home_address'],
                'monthly_income' => $beneficiaryRequest['monthly_income'],
                'current_job' => $beneficiaryRequest['current_job'],
                'monthly_income_source' => $beneficiaryRequest['monthly_income_source'],
                'number_of_needy' => $beneficiaryRequest['number_of_needy'],
                'expected_cost' => $beneficiaryRequest['expected_cost'],
                'description' => $beneficiaryRequest['description'],
                'severity_level' => $beneficiaryRequest['severity_level'],
                'document_path' => $beneficiaryRequest['document_path'],
                'current_housing_condition' => $beneficiaryRequest['current_housing_condition'],
                'needed_housing_help' => $beneficiaryRequest['needed_housing_help'],
                'status' => $beneficiaryRequest['status'],
            ]);
        }

        RequestedSupply::create([
            'beneficiary_request_id' => 3,
            'supply_id' => 3
        ]);
        RequestedSupply::create([
            'beneficiary_request_id' => 3,
            'supply_id' => 5
        ]);
        RequestedSupply::create([
            'beneficiary_request_id' => 4,
            'supply_id' => 4
        ]);
        RequestedSupply::create([
            'beneficiary_request_id' => 8,
            'supply_id' => 1
        ]);
        RequestedSupply::create([
            'beneficiary_request_id' => 8,
            'supply_id' => 2
        ]);
        RequestedSupply::create([
            'beneficiary_request_id' => 9,
            'supply_id' => 1
        ]);
    }
}
