<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\MetricCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MetricsSummaryFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Получать год и компанию из реквеста, потом подставлять, если нормальная
        $year = $request['year'];
        $сompany = Auth::user()->company()->first() ?? Company::find($request['company_id']);

        if (!$сompany) {
            $сompany = Company::orderBy('id')->first();
        }

        //Найти минимальный год для фильтра
        //определяется как максимум среди минимальной даты действия показателей и минимальной из дат начала ввода по организации
        $minMetricDates = DB::table('metrics as m')
            ->join('metric_periods as mp', 'm.metric_period_id', '=', 'mp.id')
            ->whereIn('m.metric_category_id', MetricCategory::available()->pluck('id')->toArray())
            ->select('mp.system_name', \DB::raw("MIN(m.date_begin) AS min_date"))
            ->groupBy('mp.system_name')
            ->get()
        ;

        $minMetricDateYear = $сompany->date_begin_year;
        $minMetricDateQuarter = $сompany->date_begin_quarter;
        $minMetricDateMonth = $сompany->date_begin_month;

        foreach($minMetricDates as $minMetricDate) {
            if ($minMetricDate->system_name === 'year') {
                $minMetricDateYear = $minMetricDate->min_date;
            }
            if ($minMetricDate->system_name === 'quarter') {
                $minMetricDateQuarter = $minMetricDate->min_date;
            }
            if ($minMetricDate->system_name === 'month') {
                $minMetricDateMonth = $minMetricDate->min_date;
            }
        }

        $minDate = min(
            max($minMetricDateYear, $сompany->date_begin_year),
            max($minMetricDateQuarter, $сompany->date_begin_quarter),
            max($minMetricDateMonth, $сompany->date_begin_month)
        );

        $minYear = Carbon::create($minDate)->format('Y');
        $maxYear = now()->year;

        $currentYear = null;

        if ($year && is_numeric($year)) {
            if ($year < $minYear) {
                $currentYear = $minYear;
            } elseif ($year > $maxYear) {
                $currentYear = $minYear;
            } else {
                $currentYear = $year;
            }
        } else {
            $currentYear = now()->month === 1 ? now()->year - 1 : now()->year;
        }

        $filterData = [
            "years" => [
                "min" => intval($minYear),
                "current" => intval($currentYear),
                "max" => intval($maxYear)
            ],
        ];

        if (!Auth::user()->company_id) {
            $filterData['company_id'] = $сompany->id;
            $filterData['companies'] = Company::all(['id', 'name']);
        }

        return Response([
            "data" => $filterData
        ]);
    }

}
