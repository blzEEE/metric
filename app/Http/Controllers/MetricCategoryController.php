<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MetricCategoryRequest;
use App\Http\Resources\MetricsCategoryResource;
use App\Models\MetricCategory;
use App\Models\Metric;
use App\Models\MetricCalcData;
use App\Models\InputDocumentValue;
use Illuminate\Http\Request;


class MetricCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = MetricCategory::with('metrics')
            ->with('metrics.metricPeriod')
            ->get();

        return MetricsCategoryResource::collection($categories);
    }

    public function store(MetricCategoryRequest $request)
    {
        $metricCategory = MetricCategory::create($request->validated());
        return new MetricsCategoryResource($metricCategory);
    }

    public function show(int $id)
    {
        $metricCategory = MetricCategory::findOrFail($id);
        return new MetricsCategoryResource($metricCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MetricCategoryRequest  $request
     * @param  MetricCategory  $metricCategory
     * @return MetricsCategoryResource
     */
    public function update(MetricCategoryRequest $request, MetricCategory $metricCategory)
    {
        $metricCategory->update($request->validated());
        return new MetricsCategoryResource($metricCategory);
    }

    public function destroy(MetricCategory $metricCategory)
    {
        $metrics = Metric::where('metric_category_id', '=', $metricCategory['id'])->get();
        $inputDocumentValues = [];
        $metricCalcDatas = [];

        foreach ($metrics as $metric) {
            array_push($inputDocumentValues, InputDocumentValue::where('metric_id', '=', $metric['id'])->get());
            array_push($metricCalcDatas, MetricCalcData::select('id')->where('metric_id', '=', $metric['id'])->get());
        }
        foreach ($inputDocumentValues as $inputDocumentValue) {
            if(count($inputDocumentValue)){
                return response(['message' => 'Есть заполненные документы в удаляемой категории'], 406);
            }
        }

        foreach ($metricCalcDatas as $metricCalcData) {
            foreach ($metricCalcData as $calcData) {
                MetricCalcData::find($calcData['id'])->delete();
            }
        }
        Metric::destroy($metrics);
        $metricCategory->delete();

        return response(null, 204);
    }
}
