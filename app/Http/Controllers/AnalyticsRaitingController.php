<?php

namespace App\Http\Controllers;

use App\Models\InputDocument;
use App\Models\MetricPeriod;
use Illuminate\Http\Request;
use App\Models\MetricCategory;
use App\Models\Metric;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsRaitingController extends Controller
{
    /**
     * 
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request['year'] ?? date("Y");
        $quarter = $request['quarter'] ?? null;
        $month = $request['month'] ?? null;
        $category_id = $request['category'] ?? null;
        
        
        $myCompany = Auth::user()->company()->first() ?? Company::find($request['id_company']);

        $date_begin_year = $myCompany->date_begin_year;
        $date_begin_quarter = $myCompany->date_begin_quarter;
        $date_begin_month = $myCompany->date_begin_month;

        $availablePeriods = DB::table('metrics')
            ->join('metric_periods', 'metrics.metric_period_id', '=', 'metric_periods.id')
            ->whereIn('metrics.metric_category_id', MetricCategory::available()->pluck('id')->toArray())
            ->distinct()
            ->pluck('metric_periods.system_name')
            ->toArray();

        $metricCategories = [];

        foreach (MetricCategory::available()->get() as $metricCategory) {

            $availableCategoryPeriods = DB::table('metrics')
                ->join('metric_periods', 'metrics.metric_period_id', '=', 'metric_periods.id')
                ->where('metrics.metric_category_id', $metricCategory->id)
                ->select('metric_periods.id', 'metric_periods.system_name')
                ->distinct()
                ->get();

            $documents = InputDocument::where([['metric_category_id', $metricCategory->id], ['year', $year]])->get();

            $documentsArray = [];

            foreach ($availableCategoryPeriods as $categoryPeriod) {

                if ($categoryPeriod->system_name === 'year') {

                    $yearDocument = $documents->filter(function($value, $key) use ($categoryPeriod) {
                        if ($value['metric_period_id'] === $categoryPeriod->id) {
                            return true;
                        }
                    });

                    $documentsArray[$categoryPeriod->system_name] = $yearDocument->first() ?? (Carbon::today() >= Carbon::create($year + 1, 1, 1, 0) && (!$date_begin_year || Carbon::create($date_begin_year) <= Carbon::create($year, 1, 1, 0)) ? ["id" => null] : null);
                }

                if ($categoryPeriod->system_name === 'quarter') {
                    for($i = 1; $i <= 4; $i++) {
                        $documentsArray[$categoryPeriod->system_name][$i] = null;

                        $quarterDocument = $documents->filter(function($value, $key) use ($categoryPeriod, $i) {
                            if ($value['metric_period_id'] === $categoryPeriod->id && $value['quarter'] === $i) {
                                return true;
                            }
                        });

                        $documentsArray[$categoryPeriod->system_name][$i] = $quarterDocument->first() ?? (Carbon::today() >= Carbon::create($year, $i * 3 + 1, 1, 0) && (!$date_begin_quarter || Carbon::create($date_begin_quarter) <= Carbon::create($year, $i * 3, 1, 0)) ? ["id" => null] : null);
                    }
                }

                if ($categoryPeriod->system_name === 'month') {
                    for($i = 1; $i <= 12; $i++) {
                        $documentsArray[$categoryPeriod->system_name][$i] = null;

                        $monthDocument = $documents->filter(function($value, $key) use ($categoryPeriod, $i) {
                            if ($value['metric_period_id'] === $categoryPeriod->id && $value['quarter'] === intval(ceil($i/3)) && $value['month'] === $i) {
                                return true;
                            }
                        });

                        $documentsArray[$categoryPeriod->system_name][$i] = $monthDocument->first() ?? (Carbon::today() >= Carbon::create($year, $i + 1, 1, 0) && (!$date_begin_month || Carbon::create($date_begin_month) <= Carbon::create($year, $i, 1, 0)) ? ["id" => null] : null);
                    }
                }
            }

            $metricCategories[] = [
                "id" => $metricCategory->id,
                "name" => $metricCategory->name,
                "documents" => $documentsArray
            ];
        }

        return Response([
            "data" => [
                "year" => $year,
                "available_periods" => $availablePeriods,
                "metric_categories" => $metricCategories
            ]
        ]);
    }
}
