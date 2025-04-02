<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MetricCalcDataRequest;
use App\Models\MetricCalcData;
use App\Http\Resources\MetricCalcDataResource;

class MetricCalcDataController extends Controller
{
    public function index(Request $request)
    {
        $metricCalcData = MetricCalcData::where('metric_id', '=', $request->get('metric_id'))
            ->sortBy('name')
            ->get();
        return MetricCalcDataResource::collection($metricCalcData);
    }
}
