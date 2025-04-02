<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyLevel;
use App\Http\Resources\CompanyLevelResource;

class CompanyLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyLevels = CompanyLevel::all()->sortBy('id');
        return CompanyLevelResource::collection($companyLevels);
    }
}
