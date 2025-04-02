<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyTypeResource;
use App\Models\CompanyType;
use Illuminate\Http\Request;

class CompanyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyTypes = CompanyType::all()->sortBy('id');
        return CompanyTypeResource::collection($companyTypes);
    }
}
