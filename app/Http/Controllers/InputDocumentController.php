<?php

namespace App\Http\Controllers;

use App\Http\Resources\MetricResource;
use App\Models\InputDocumentStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InputDocumentRequest;
use App\Http\Requests\NewInputDocumentRequest;
use App\Http\Resources\InputDocumentResource;
use App\Models\Metric;
use App\Models\MetricPeriod;
use App\Models\MetricCategory;
use App\Models\UserRole;
use App\Models\InputDocument;
use App\Models\InputDocumentValue;
use App\Models\InputDocumentValueCalcData;

class InputDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  NewInputDocumentRequest  $request
     * @return ResourceCollection
     */
    public function index(NewInputDocumentRequest $request)
    {
        $newInputDocumentValidated = $request->validated();

        $metricCategory = MetricCategory::available()->findOrFail($newInputDocumentValidated['metric_category_id']);
        $metricPeriod = MetricPeriod::findOrFail($newInputDocumentValidated['metric_period_id']);

        $year = $newInputDocumentValidated['year'];
        $quarter = $newInputDocumentValidated['quarter'] ?? 0;
        $month = $newInputDocumentValidated['month'] ?? 0;

        $targetMonth = 1;
        switch ($metricPeriod->id) {
            case MetricPeriod::PERIOD_MONTH:
                $targetMonth = $month;
                break;
            case MetricPeriod::PERIOD_QUARTER:
                $targetMonth = intval(ceil($quarter * 3 - 2));
                break;
            case MetricPeriod::PERIOD_YEAR:
                $targetMonth = 1;
                break;
        }

        $targetDate = Carbon::create($year, $targetMonth, 1, 0);

        $metrics = Metric::with('metricCalcData')
            ->with('metricUnit')
            ->where('metrics.metric_category_id', $metricCategory->id)
            ->where('metrics.metric_period_id', $metricPeriod->id)
            ->whereDate('metrics.date_begin', '<=', $targetDate)
            ->where(function($query) use ($targetDate) {
                $query->whereDate('metrics.date_end', '>=', $targetDate);
                $query->orWhereNull('metrics.date_end');
            })
            ->get();

        return MetricResource::collection($metrics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InputDocumentRequest  $request
     * @return InputDocumentResource
     */
    public function store(InputDocumentRequest $request)
    {
        $inputDocumentValidated = $request->validated();

        $inputDocument = new InputDocument;
        $inputDocument->fill($inputDocumentValidated);
        $inputDocument->user_id = Auth::user()->id;
        $inputDocument->company_id = Auth::user()->company_id ?? $inputDocumentValidated['company_id'];
        $inputDocument->input_document_status_id = InputDocumentStatus::STATUS_DRAFT;
        $inputDocument->save();

        foreach($inputDocumentValidated['input_document_values'] as $inputDocumentValueRequest) {

            $inputDocumentValue = new InputDocumentValue;
            $inputDocumentValue->fill($inputDocumentValueRequest);
            $inputDocumentValue->input_document_id = $inputDocument->id;
            $inputDocumentValue->save();

            if (array_key_exists('input_document_value_calc_data', $inputDocumentValueRequest)) {
                foreach ($inputDocumentValueRequest['input_document_value_calc_data'] as $inputDocumentValueCalcDataRequest) {

                    $inputDocumentValueCalcData = new InputDocumentValueCalcData;
                    $inputDocumentValueCalcData->fill($inputDocumentValueCalcDataRequest);
                    $inputDocumentValueCalcData->input_document_value_id = $inputDocumentValue->id;
                    $inputDocumentValueCalcData->save();
                }
            }
        }

        return new InputDocumentResource($inputDocument);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $inputDocument = InputDocument::with('user')
            ->with('inputDocumentValues')
            ->with('inputDocumentValues.metric')
            ->with('inputDocumentValues.metric.metricUnit')
            ->with('inputDocumentValues.inputDocumentValueCalcData')
            ->with('inputDocumentValues.inputDocumentValueCalcData.metricCalcData')
            ->findOrFail($id);

        return new InputDocumentResource($inputDocument);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  InputDocumentRequest $request
     * @param  InputDocument $inputDocument
     * @return InputDocumentResource
     */
    public function update(InputDocumentRequest $request, InputDocument $inputDocument)
    {
        //TODO при обновлении в случае изменения состава документа обрабатывать новые и удаленные строки
        $inputDocumentValidated = $request->validated();

        if ($inputDocument->input_document_status_id === 1) { // Позволяем обновлять только черновик

            $inputDocument->fill($inputDocumentValidated);
            $inputDocument->save();

            foreach($inputDocumentValidated['input_document_values'] as $inputDocumentValueRequest) {

                $inputDocumentValue = InputDocumentValue::find($inputDocumentValueRequest['id']);
                $inputDocumentValue->value = $inputDocumentValueRequest['value'];
                $inputDocumentValue->is_active = $inputDocumentValueRequest['is_active'];
                $inputDocumentValue->save();

                if (array_key_exists('input_document_value_calc_data', $inputDocumentValueRequest)) {
                    foreach ($inputDocumentValueRequest['input_document_value_calc_data'] as $inputDocumentValueCalcDataRequest) {

                        $inputDocumentValueCalcData = InputDocumentValueCalcData::find($inputDocumentValueCalcDataRequest['id']);
                        $inputDocumentValueCalcData->value = $inputDocumentValueCalcDataRequest['value'];
                        $inputDocumentValueCalcData->save();
                    }
                }
            }
        }

        return new InputDocumentResource($inputDocument);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inputDocument = InputDocument::findOrFail($id);

        if (Auth::user()->user_role_id === UserRole::ROLE_SYSADMIN
            || (Auth::user()->company_id === $inputDocument->company_id && $inputDocument->input_document_status_id === 1)) {

            foreach($inputDocument->inputDocumentValues()->get() as $inputDocumentValue) {
                $inputDocumentValue->inputDocumentValueCalcData()->delete();
            }

            $inputDocument->inputDocumentValues()->delete();

            $inputDocument->delete();

            return response(null, 204);
        } else {
            return response(null, 403);
        }
    }
}
