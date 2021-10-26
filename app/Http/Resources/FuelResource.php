<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FuelResource extends JsonResource
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
            'car' => $this->car->licenseNo,
            'agent' => $this->agent->name,
        ]);

        unset($response['agentId']);

        return $response;
    }
}
