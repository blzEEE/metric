<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InputDocumentValueCalcDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'input_document_value_id' => $this->input_document_value_id,
            'metric_calc_data_id' => $this->metric_calc_data_id,
            'metric_calc_data' => new MetricCalcDataResource($this->whenLoaded('metricCalcData')),
            'value' => $this->value,
        ];
    }
}
