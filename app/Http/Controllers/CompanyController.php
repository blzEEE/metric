<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $companies = Company::with('region')
            ->withCount('users')
            ->where('name', 'like', '%'.$request->get('search').'%')
            ->orWhere('short_name', 'like', '%'.$request->get('search').'%')
            ->paginate(10)
            ->onEachSide(1);
        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyRequest  $request
     * @return CompanyResource
     */
    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->validated());
        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return CompanyResource
     */
    public function show(int $id)
    {
        $company = Company::findOrFail($id);
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyRequest  $request
     * @param  Company  $company
     * @return CompanyResource
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());
        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company  $company
     * @return Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response(null, 204);
    }
}
