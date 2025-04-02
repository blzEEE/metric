<?php

namespace App\Http\Controllers;

use App\Models\MetricPeriod;
use App\Http\Resources\MetricPeriodResource;

class MetricPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metricPeriods = MetricPeriod::all()->sortBy('id');
        return MetricPeriodResource::collection($metricPeriods);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $metricPeriod = MetricPeriod::findOrFail($id);
        return new MetricPeriodResource($metricPeriod);
    }
}
