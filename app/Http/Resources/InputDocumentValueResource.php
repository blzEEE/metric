<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InputDocumentValueResource extends JsonResource
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
            'input_document_id' => $this->input_document_id,
            'metric_id' => $this->metric_id,
            'metric' => new MetricResource($this->whenLoaded('metric')),
            'input_document_value_calc_data' => InputDocumentValueCalcDataResource::collection($this->whenLoaded('inputDocumentValueCalcData')),
            'value' => $this->value,
            'is_active' => $this->is_active
        ];
    }
}
