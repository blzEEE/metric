<?php

namespace App\Http\Requests;

use App\Models\CompanyOwnership;
use App\Models\CompanyType;
use App\Models\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
        //TODO проверять для date_begin_year, date_begin_quarter, date_begin_month не было ли уже введено па данной организации показателей с соответствующими периодичностями позже указанных периодов
        $rules = [
            'region_id' => ['required', 'integer'],
            'city' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:50', 'unique:companies,short_name'],
            'address' => ['string', 'max:255', 'nullable'],
            'director_position' => ['string', 'max:100', 'nullable'],
            'director_name' => ['string', 'max:100', 'nullable'],
            'company_type_id' => ['integer', 'nullable'],
            'company_ownership_id' => ['integer', 'nullable'],
            'company_level_id' => [
                'integer',
                'nullable',
                Rule::requiredIf($this->company_ownership_id === CompanyOwnership::OWNERSHIP_STATE)
            ],
            'company_bed_capacity_id' => ['integer', 'nullable'],
            'is_emergency' => ['boolean', 'nullable'],
            'date_begin_year' => ['required', 'date'],
            'date_begin_quarter' => ['required', 'date'],
            'date_begin_month' => ['required', 'date'],
        ];

        switch ($this->getMethod())
        {
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                        'id' => ['required', 'integer', 'exists:companies,id'], //должен существовать
                        'short_name' => [
                            'required',
                            Rule::unique('companies')->ignore($this->id) //должен быть уникальным, за исключением себя же
                        ],
                        'company_type_id' => ['required', 'integer'],
                        'company_ownership_id' => ['required', 'integer'],
                        'company_bed_capacity_id' => ['required', 'integer'],
                        'is_emergency' => ['boolean'],
                    ] + $rules; // и берем все остальные правила
            case 'DELETE':
                return [
                    'id' => ['required', 'integer', 'exists:companies,id'], //должен существовать
                ];
        }

    }

    public function messages():array
    {
        return [
            'region_id.required' => 'Выберите регион',
            'city.required' => 'Укажите город',
            'name.required' => 'Заполните наименование организации',
            'short_name.required' => 'Заполните сокращенное наименование',
            'short_name.unique' => 'Такое сокращенное наименование уже существует',
            'company_type_id.required' => 'Выберите вид организации',
            'company_ownership_id.required' => 'Выберите форму юридического лица',
            'company_level_id.required' => 'Выберите территориальный признак',
            'company_bed_capacity_id.required' => 'Выберите коечную мощность',
            'date_begin_year.required' => 'Укажите период начала сбора годовых показателей',
            'date_begin_year.date' => 'Укажите период начала сбора годовых показателей',
            'date_begin_quarter.required' => 'Укажите период начала сбора квартальных показателей',
            'date_begin_quarter.date' => 'Укажите период начала сбора квартальных показателей',
            'date_begin_month.required' => 'Укажите период начала сбора ежемесячных показателей',
            'date_begin_month.date' => 'Укажите период начала сбора ежемесячных показателей',
            'is_emergency.boolean' => 'Укажите критерий экстренной помощи',
        ];
    }
}
