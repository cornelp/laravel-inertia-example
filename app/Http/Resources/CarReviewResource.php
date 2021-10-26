<?php

namespace App\Http\Resources;

use App\Enums\CarReviewType;
use Illuminate\Http\Resources\Json\JsonResource;

class CarReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = array_merge(parent::toArray($request), [
            'typeName' => CarReviewType::getDescription($this->typeId),
            'type' => $this->typeId,
        ]);

        return $response;
    }
}
