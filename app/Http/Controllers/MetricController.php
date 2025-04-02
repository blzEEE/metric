<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetricRequest;
use App\Http\Resources\MetricResource;
use App\Models\InputDocument;
use App\Models\Metric;
use App\Models\MetricUnit;
use App\Models\MetricCalcData;
use App\Models\InputDocumentValue;
use Illuminate\Http\Request;

class MetricController extends Controller
{
    public function index(Request $request)
    {
        $metrics = Metric::where('metric_category_id', '=', $request->get('categoryId'))
            ->sortBy('metric_period_id')
            ->get();
        return MetricResource::collection($metrics);
    }

    public function store(MetricRequest $request)
    {
        $validatedData = $request->validated();

        $metricUnit = MetricUnit::firstOrCreate(['name' => $validatedData['metric_unit']['name']]);

        $newMetric = new Metric;
        $newMetric->fill($validatedData);
        $newMetric->metric_unit_id = $metricUnit->id;
        $newMetric->save();

        foreach($validatedData['metric_calc_data'] as $metricCalcData){
            $newMetricCalcData = new MetricCalcData();
            $newMetricCalcData->fill($metricCalcData);
            $newMetricCalcData->metric_id = $newMetric->id;
            $newMetricCalcData->save();
        }

        return new MetricResource($newMetric);
    }

    public function show(int $id)
    {
        $metric = Metric::with('metricUnit')
            ->with('metricCalcData')
            ->withCount('inputDocumentValue')
            ->findOrFail($id);
        return new MetricResource($metric);
    }

    public function update(MetricRequest $request, Metric $metric)
    {
        $validatedData = $request->validated();        

        $metric->metricCalcData()->whereNotIn('id', collect($validatedData['metric_calc_data'])->whereNotNull('id')->pluck('id'))->delete();

        foreach ($validatedData['metric_calc_data'] as $metricCalcDataRequest) {
            MetricCalcData::updateOrCreate(['id' => $metricCalcDataRequest['id']], $metricCalcDataRequest);
        }

        $metric->fill($validatedData);

        $newMetricUnit = MetricUnit::firstOrCreate(['name' => $validatedData['metric_unit']['name']]);
        $metric->metric_unit_id = $newMetricUnit->id;

        $metric->save();

        return new MetricResource($metric);
    }

    public function destroy(Metric $metric)
    {
        $inputDocumentsCount = InputDocumentValue::where('metric_id', '=', $metric['id'])->count();

        if ($inputDocumentsCount) {
            return response(['message' => 'Есть заполненные документы с удаляемым показателем'], 406);
        } else {
            $metric->metricCalcData()->delete();
            $metric->delete();

            return response(null, 204);
        }


    }
}
