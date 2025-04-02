<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InputDocumentResource extends JsonResource
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
            'company_id' => $this->company_id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'metric_category_id' => $this->metric_category_id,
            'metric_category' => $this->metricCategory,
            'input_document_status_id' => $this->input_document_status_id,
            'metric_period_id' => $this->metric_period_id,
            'metric_period' => $this->metricPeriod,
            'year' => $this->year,
            'quarter' => $this->quarter,
            'month' => $this->month,
            'created_at' => $this->created_at,
            'input_document_values' => InputDocumentValueResource::collection($this->whenLoaded('inputDocumentValues'))
        ];
    }
}
