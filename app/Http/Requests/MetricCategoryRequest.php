<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\MetricCategory;

class MetricCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:metric_categories,name'],
        ];

        switch ($this->getMethod()){
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                    'id' => ['required', 'integer', 'exists:metric_categories,id'],
                    'name' => [
                        'required',
                        Rule::unique('metric_categories')->ignore($this->id) //должен быть уникальным, за исключением себя же
                    ]
                ] + $rules;
            case 'DELETE':
                return [
                    'id' => ['required', 'integer', 'exists:metric_categories,id']
                ];
        }
    }

    public function messages():array
    {
        return [
            'name.required' => 'Укажите имя категории'
        ];
    }
}
