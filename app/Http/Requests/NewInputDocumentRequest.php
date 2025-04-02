<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\MetricPeriod;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NewInputDocumentRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'metric_category_id' => ['required', 'integer', 'exists:metric_categories,id'],
            'metric_period_id' => ['required', 'integer', 'exists:metric_periods,id'],
            'year' => ['required', 'integer', 'min:2000', 'max:2099'],
            'quarter' => [
                'integer',
                'min:0', 'max:4',
                'nullable',
                Rule::requiredIf($this->metric_period_id == MetricPeriod::PERIOD_QUARTER)
            ],
            'month' => [
                'integer',
                'min:0', 'max:12',
                'nullable',
                Rule::requiredIf($this->metric_period_id == MetricPeriod::PERIOD_MONTH)
            ],
            'company_id' => [
                'integer',
                'nullable',
                Rule::requiredIf(Auth::user()->user_role_id === UserRole::ROLE_SYSADMIN),
                function($attribute, $value, $fail) {
                    $company = Auth::user()->company()->first() ?? Company::find($this->company_id);

                    if (!$company) {
                        $fail('Не удалось определить организацию для ввода показателей');
                    }

                    $date_begin_year = $company->date_begin_year;
                    $date_begin_quarter = $company->date_begin_quarter;
                    $date_begin_month = $company->date_begin_month;

                    //Проверим на попытку заполнения показателей в будущем периоде
                    //Проверим, что за этот период организации уже разрешено заполнять
                    $isFuturePeriod = false;
                    $isBeforeBegin = false;
                    switch ($this->metric_period_id) {
                        case MetricPeriod::PERIOD_MONTH:
                            if (Carbon::today() < Carbon::create($this->year, $this->month + 1, 1, 0)) {
                                $isFuturePeriod = true;
                            }

                            if (Carbon::create($date_begin_month) > Carbon::create($this->year, $this->month, 1, 0)) {
                                $isBeforeBegin = true;
                            }
                            break;
                        case MetricPeriod::PERIOD_QUARTER:
                            if (Carbon::today() < Carbon::create($this->year, $this->quarter * 3 + 1, 1, 0)) {
                                $isFuturePeriod = true;
                            }

                            if (Carbon::create($date_begin_quarter) > Carbon::create($this->year, $this->quarter * 3, 1, 0)) {
                                $isBeforeBegin = true;
                            }
                            break;
                        case MetricPeriod::PERIOD_YEAR:
                            if (Carbon::today() < Carbon::create($this->year + 1, 1, 1, 0)) {
                                $isFuturePeriod = true;
                            }

                            if (Carbon::create($date_begin_year) > Carbon::create($this->year, 1, 1, 0)) {
                                $isBeforeBegin = true;
                            }
                            break;
                    }

                    if ($isBeforeBegin || $isFuturePeriod) {
                        $fail('Указанный период недоступен для ввода показателей');
                    }
                },
            ],
        ];
    }

    public function messages():array
    {
        $messages = [
            'quarter.min' => 'Номер квартала не должен выходить за пределы от I до IV',
            'quarter.max' => 'Номер квартала не должен выходить за пределы от I до IV',
            'month.min' => 'Месяц не должен выходить за пределы от 1 до 12',
            'month.max' => 'Месяц не должен выходить за пределы от 1 до 12',
            'year.min' => 'Год не должен выходить за пределы от 2000 до 2099',
            'year.max' => 'Год не должен выходить за пределы от 2000 до 2099',
        ];

        return $messages;
    }
}
