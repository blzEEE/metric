<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyOwnership;
use App\Http\Resources\CompanyOwnershipResource;

class CompanyOwnershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyOwnerships = CompanyOwnership::all()->sortBy('id');
        return CompanyOwnershipResource::collection($companyOwnerships);
    }
}
