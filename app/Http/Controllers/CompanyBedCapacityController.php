<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyBedCapacityResource;
use App\Models\CompanyBedCapacity;
use Illuminate\Http\Request;

class CompanyBedCapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyBedCapacities = CompanyBedCapacity::all()->sortBy('id');
        return CompanyBedCapacityResource::collection($companyBedCapacities);
    }
}
