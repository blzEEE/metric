<?php

namespace App\Http\Requests;

use App\Models\CompanyOwnership;
use App\Models\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InputDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->user_role_id === UserRole::ROLE_SYSADMIN
            || Auth::user()->company_id === $this->company_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        //TODO сделать правило на уникальность сочетания полей ['company_id', 'metric_category_id', 'metric_period_id', 'year', 'quarter', 'month']
        //TODO сделать правило валидации для проверки на истекший период для ввода и доступность показателей по периоду для ввода, а также доступность организации по периоду для ввода
        $rules = [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'metric_category_id' => ['required', 'integer', 'exists:metric_categories,id'],
            'metric_period_id' => ['required', 'integer', 'exists:metric_periods,id'],
            'year' => ['required', 'integer', 'min:2000', 'max:2099'],
            'quarter' => ['integer', 'min:0', 'max:4', 'nullable'],
            'month' => ['integer', 'min:0', 'max:12', 'nullable'],

            'input_document_values' => ['required', 'array'],
            'input_document_values.*.metric_id' => ['required', 'integer', 'exists:metrics,id'],
            'input_document_values.*.value' => [
                'numeric',
                'min:0',
                'nullable',
                'required_if:input_document_values.*.is_active,true'
            ],
            'input_document_values.*.is_active' => ['required', 'boolean'],

            'input_document_values.*.input_document_value_calc_data' => ['required', 'array'],
            'input_document_values.*.input_document_value_calc_data.*.metric_calc_data_id' => ['required', 'integer', 'exists:metric_calc_data,id'],
            'input_document_values.*.input_document_value_calc_data.*.value' => [
                'numeric',
                'min:0',
                'nullable',
                'required_if:input_document_values.*.is_active,true'
             ],
        ];

        switch ($this->getMethod())
        {
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                        'id' => ['required', 'integer', 'exists:input_documents,id'], //должен существовать

                        'input_document_values.*.id' => ['required', 'integer', 'exists:input_document_values,id'],
                        'input_document_values.*.input_document_id' => ['required', 'integer', 'exists:input_documents,id'],

                        'input_document_values.*.input_document_value_calc_data.*.id' => ['required', 'integer', 'exists:input_document_value_calc_data,id'],
                        'input_document_values.*.input_document_value_calc_data.*.input_document_value_id' => ['required', 'integer', 'exists:input_document_values,id']
                    ] + $rules; // и берем все остальные правила
            case 'DELETE':
                return [
                    'id' => ['required', 'integer', 'exists:input_documents,id'], //должен существовать
                ];
        }

    }

    public function messages():array
    {
        $messages = [
            'input_document_values.*.input_document_value_calc_data.required' => 'Данные для расчета должны быть заполнены',
            'input_document_values.*.input_document_value_calc_data.*.value.required' => 'Данные для расчета должны быть заполнены',
            'input_document_values.*.input_document_value_calc_data.*.value.min' => 'Значения данных для расчета не должны быть меньше 0',
            'input_document_values.required' => 'В документе должен быть запонен хотя бы один показатель',
        ];

        return $messages;
    }
}
