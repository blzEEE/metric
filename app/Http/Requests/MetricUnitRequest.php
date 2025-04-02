<?php

namespace App\Http\Requests;

use App\Models\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MetricUnitRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
        ];
        
        switch ($this->getMethod()){
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                    'id' => ['required', 'integer', 'exists:metric_unit,id'],
                    'name' => [
                        'required',
                        Rule::unique('metric_unit')->ignore($this->id)
                    ]
                ] + $rules;
            case 'DELETE':
                return [
                    'id' => ['required', 'integer', 'exists:metric_unit,id'],
                ];
        }
    }

    public function messages():array
    {
        return [
            'name.required' => 'Укажите название единицы измерения',
        ];
    }
}
