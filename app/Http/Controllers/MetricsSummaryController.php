<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MetricCategory;
use App\Models\InputDocument;
use App\Models\Company;

class MetricsSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request['year'] ?? date("Y");
        $company = Auth::user()->company()->first() ?? Company::find($request['company_id']);

        $companyDateBeginYear = $company->date_begin_year;
        $companyDateBeginQuarter = $company->date_begin_quarter;
        $companyDateBeginMonth = $company->date_begin_month;

        $availablePeriods = DB::table('metrics as m')
            ->join('metric_periods as mp', 'm.metric_period_id', '=', 'mp.id')
            ->whereIn('m.metric_category_id', MetricCategory::available()->pluck('id')->toArray())
            ->whereYear('m.date_begin', '<=', $year)
            ->where(function($query) use ($year) {
                $query->whereYear('m.date_end', '>=', $year);
                $query->orWhereNull('m.date_end');
            })
            ->distinct()
            ->pluck('mp.system_name')
            ->toArray();

        $metricCategories = [];

        foreach (MetricCategory::available()->hasMetrics($year)->orderBy('name')->get() as $metricCategory) {

            $availableCategoryPeriods = DB::table('metrics as m')
                ->join('metric_periods as mp', 'm.metric_period_id', '=', 'mp.id')
                ->where('m.metric_category_id', $metricCategory->id)
                ->whereYear('m.date_begin', '<=', $year)
                ->where(function($query) use ($year) {
                    $query->whereYear('m.date_end', '>=', $year);
                    $query->orWhereNull('m.date_end');
                })
                ->select('mp.id', 'mp.system_name', DB::raw('MIN(m.date_begin) as min_date_begin'), DB::raw('MAX(IFNULL(m.date_end, DATE_ADD(NOW(), INTERVAL 1 YEAR))) as max_date_end'))
                ->groupBy('mp.id', 'mp.system_name')
                ->get();

            $documents = InputDocument::where([
                ['company_id', $company->id],
                ['metric_category_id', $metricCategory->id],
                ['year', $year]
            ])->get();

            $documentsArray = [];

            foreach ($availableCategoryPeriods as $categoryPeriod) {

                if ($categoryPeriod->system_name === 'year') {

                    $dateBeginYear = max($companyDateBeginYear, $categoryPeriod->min_date_begin);
                    $dateEndYear = $categoryPeriod->max_date_end;

                    $yearDocument = $documents->filter(function($value, $key) use ($categoryPeriod) {
                        return $value['metric_period_id'] === $categoryPeriod->id;
                    });

                    //В массив документов добавляем найденный документ, либо данные о возможности ввода нового документа
                    $documentsArray[$categoryPeriod->system_name] = $yearDocument->first() ??
                        (
                            //Если начало сбора показателей для компании/минимальная дата начала сбора показателя в категории больше, чем запрашиваемый год (не включает)
                            Carbon::create($dateBeginYear) > Carbon::create($year, 1, 1, 0)
                                //Либо максимальная дата окончания сбора показателя меньше, чем запрашиваемый год (не включает)
                                || Carbon::create($dateEndYear) < Carbon::create($year, 1, 1, 0)
                            ? null //Ввод показателей недоступен
                            :
                                (
                                    //Если запрашиваемый год фактически истёк
                                    Carbon::today() >= Carbon::create($year + 1, 1, 1, 0)
                                    ? ["id" => null, "ready" => true] //Требуется ввод показателей
                                    : ["id" => null, "ready" => false, "date_ready" => Carbon::create($year + 1, 1, 1, 0)->format('d.m.Y')] //Ввод показателей будет доступен позже
                                )
                        );
                }

                if ($categoryPeriod->system_name === 'quarter') {

                    $dateBeginQuarter = max($companyDateBeginQuarter, $categoryPeriod->min_date_begin);
                    $dateEndQuarter = $categoryPeriod->max_date_end;

                    for($i = 1; $i <= 4; $i++) {

                        $quarterDocument = $documents->filter(function($value, $key) use ($categoryPeriod, $i) {
                            return $value['metric_period_id'] === $categoryPeriod->id
                                && $value['quarter'] === $i;
                        });

                        $documentsArray[$categoryPeriod->system_name][$i] = $quarterDocument->first() ??
                            (
                                //Если начало сбора показателей для компании/минимальная дата начала сбора показателя в категории больше, чем запрашиваемый квартал (не включает)
                                Carbon::create($dateBeginQuarter) > Carbon::create($year, ($i - 1) * 3 + 1, 1, 0)
                                    //Либо максимальная дата окончания сбора показателя меньше, чем запрашиваемый год (не включает)
                                    || Carbon::create($dateEndQuarter) < Carbon::create($year, ($i - 1) * 3 + 1, 1, 0)
                                ? null //Ввод показателей недоступен
                                :
                                    (
                                        //Если запрашиваемый квартал фактически истёк
                                        Carbon::today() >= Carbon::create($year, $i * 3 + 1, 1, 0)
                                        ? ["id" => null, "ready" => true] //Требуется ввод показателей
                                        : ["id" => null, "ready" => false, "date_ready" => Carbon::create($year, $i * 3 + 1, 1, 0)->format('d.m.Y')] //Ввод показателей будет доступен позже
                                    )
                            );
                    }
                }

                if ($categoryPeriod->system_name === 'month') {

                    $dateBeginMonth = max($companyDateBeginMonth, $categoryPeriod->min_date_begin);
                    $dateEndMonth = $categoryPeriod->max_date_end;

                    for($i = 1; $i <= 12; $i++) {

                        $monthDocument = $documents->filter(function($value, $key) use ($categoryPeriod, $i) {
                            return $value['metric_period_id'] === $categoryPeriod->id
                                && $value['quarter'] === intval(ceil($i/3))
                                && $value['month'] === $i;
                        });

                        $documentsArray[$categoryPeriod->system_name][$i] = $monthDocument->first() ??
                            (
                                //Если начало сбора показателей для компании/минимальная дата начала сбора показателя в категории больше, чем запрашиваемый месяц (не включает)
                                Carbon::create($dateBeginMonth) > Carbon::create($year, $i, 1, 0)
                                    //Либо максимальная дата окончания сбора показателя меньше, чем запрашиваемый год (не включает)
                                    || Carbon::create($dateEndMonth) < Carbon::create($year, $i, 1, 0)
                                ? null //Ввод показателей недоступен
                                :
                                    (
                                        //Если запрашиваемый месяц фактически истёк
                                        Carbon::today() >= Carbon::create($year, $i + 1, 1, 0)
                                        ? ["id" => null, "ready" => true] //Требуется ввод показателей
                                        : ["id" => null, "ready" => false, "date_ready" => Carbon::create($year, $i + 1, 1, 0)->format('d.m.Y')] //Ввод показателей будет доступен позже
                                    )
                            );
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
