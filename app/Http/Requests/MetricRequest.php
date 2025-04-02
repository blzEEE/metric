<?php

namespace App\Http\Requests;

use App\Models\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MetricRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->user_role_id === UserRole::ROLE_SYSADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:metrics,name'],
            'description' => ['string', 'max:16000', 'nullable'],
            'formula' => [
                'required',
                'string',
                'max:50',
                function($attribute, $value, $fail){
                    if(!preg_match('/^[a-e\d\+\-\*\/\(\) ]+$/', $value)){
                        $fail("Формула не соответствует формату");
                    }
                }
            ],
            'date_begin' => ['required', 'date'],
            'date_end' => [
                'date',
                'nullable',
                'correctly' => function($attribute, $value, $fail){

                    $maxDocDate = DB::table('input_documents as doc')
                        ->join('input_document_values as val', 'doc.id', '=',  'val.input_document_id')
                        ->where('val.metric_id', $this->id)
                        ->select(DB::raw('MAX(DATE_ADD(MAKEDATE(doc.year, 1), INTERVAL CASE WHEN doc.month > 0 THEN doc.month - 1 ELSE CASE WHEN doc.quarter > 0 THEN (doc.quarter - 1) * 3 ELSE 0 END END MONTH)) as max_doc_date'))
                        ->value('max_doc_date');

                    if ($value <= Carbon::create($maxDocDate)) {
                        $fail('Существуют документы за более поздние даты');
                    }                    
                }
            ],
            'metric_category_id' =>['required', 'integer'],
            'metric_period_id' =>['required', 'integer'],
            'metric_target_order_id' =>['required', 'integer'],

            'metric_unit.name' => ['required', 'string', 'max:50'],

            'metric_calc_data' => ['required'],
            'metric_calc_data.*.id' => ['integer', 'max:255', 'nullable'],
            'metric_calc_data.*.name' => ['required', 'string', 'max:255'],
            'metric_calc_data.*.var_name' => ['required', 'string', 'max:1'],
            'metric_calc_data.*.metric_id' => ['integer', 'nullable']
        ];

        switch ($this->getMethod()){
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                    'id' => ['required', 'integer', 'exists:metrics,id'],
                    'name' => [
                        'required',
                        Rule::unique('metrics')->ignore($this->id)
                    ]
                ] + $rules;
            case 'DELETE':
                return [
                    'id' => ['required', 'integer', 'exists:metric,id'],
                ];
        }
    }

    public function messages():array
    {
        return [
            'name.required' => 'Укажите название показателя',
            'metric_category_id.required' => 'Укажите категорию показателя',
            'metric_unit.name' => 'Укажите единицу измерения показателя',
            'metric_period_id.required' => 'Укажите периодичность показателя',
            'metric_target_order_id.required' => 'Укажите целевое значение показателя',
            'date_begin.required' => 'Укажите дату начала ведения показателя',
            'metric_calc_data.*.name' => 'Укажите название данных для расчета',
            'metric_calc_data.required' => 'Укажите данные для расчета',
            'formula.required' => 'Укажите формулу расчета',
        ];
    }
}
