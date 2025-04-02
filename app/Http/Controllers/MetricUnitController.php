<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetricUnit;
use App\Http\Requests\MetricUnitRequest;
use App\Http\Resources\MetricUnitResource;

class MetricUnitController extends Controller
{
    public function index(Request $request){
        $metricUnits = MetricUnit::all()
            ->sortBy('name');
        return MetricUnitResource::collection($metricUnits);
    }

    public function store(MetricUnitRequest $request){
        $metricUnit = MetricUnit::create($request->validated());
        return new MetricUnitResource($metricUnit);
    }

    public function show(int $id){
        $metricUnit = MetricUnit::findOrFail($id);
        return new MetricUnitResource($metricUnit);
    }

    public function update(MetricUnitRequest $request, MetricUnit $metricUnit){
        $metricUnit->update($request->validated());
        return new MetricUnitResource($metricUnit);
    }

    public function destroy(MetricUnit $metricUnit){
        $metricUnit->delete();
        return response(null, 204);
    }
}
