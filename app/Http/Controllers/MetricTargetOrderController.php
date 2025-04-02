<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MetricTargetOrderResource;
use App\Models\MetricTargetOrder;

class MetricTargetOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metricTargetOrder = MetricTargetOrder::all()->sortBy('id');
        return MetricTargetOrderResource::collection($metricTargetOrder);
    }
}
