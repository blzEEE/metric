<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CompanyTypeController;
use App\Http\Controllers\CompanyOwnershipController;
use App\Http\Controllers\CompanyLevelController;
use App\Http\Controllers\CompanyBedCapacityController;
use App\Http\Controllers\MetricController;
use App\Http\Controllers\MetricCategoryController;
use App\Http\Controllers\MetricPeriodController;
use App\Http\Controllers\MetricTargetOrderController;
use App\Http\Controllers\MetricUnitController;
use App\Http\Controllers\MetricsSummaryFilterController;
use App\Http\Controllers\MetricsSummaryController;
use App\Http\Controllers\InputDocumentController;
use App\Http\Controllers\ApprovedDocumentController;
use App\Http\Controllers\AnalyticsRaitingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //Utils (утилиты)
    Route::get('server-date', function () {
        return Carbon::today();
    });

    //References (справочники)
    Route::get('regions', [RegionController::class, 'index']);
    Route::get('company-types', [CompanyTypeController::class, 'index']);
    Route::get('company-ownerships', [CompanyOwnershipController::class, 'index']);
    Route::get('company-levels', [CompanyLevelController::class, 'index']);
    Route::get('company-bed-capacities', [CompanyBedCapacityController::class, 'index']);
    Route::get('metric-target-orders', [MetricTargetOrderController::class, 'index']);
    Route::get('metric-periods', [MetricPeriodController::class, 'index']);
    Route::get('metric-periods/{id}', [MetricPeriodController::class, 'show']);

    //Resources (русурсы)
    //Settings
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('metric-categories', MetricCategoryController::class);
    Route::apiResource('metrics', MetricController::class);
    Route::apiResource('metric-unit', MetricUnitController::class);

    //My metrics
    Route::get('metrics-summary-filter', [MetricsSummaryFilterController::class, 'index']);
    Route::get('metrics-summary', [MetricsSummaryController::class, 'index']);
    Route::apiResource('input-documents', InputDocumentController::class);
    Route::apiResource('approved-documents', ApprovedDocumentController::class)->only(['store', 'destroy']);

    //Analytics
    Route::get('analytics-raiting', [AnalyticsRaitingController::class, 'index']);
});
