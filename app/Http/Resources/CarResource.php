<?php

namespace App\Http\Resources;

use App\Enums\AreaType;
use App\Enums\CarModelType;
use App\Enums\CarType;
use App\Enums\CityType;
use App\Enums\FuelType;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'area' => AreaType::getDescription($this->area),
            'city' => CityType::getDescription($this->city),
            'model' => CarModelType::getDescription($this->model),
            'agent' => optional($this->agent)->name,
            'fuel' => FuelType::getDescription($this->fuel),
            'type' => CarType::getDescription($this->type),
        ]);

        unset($response['agentId']);

        return $response;
    }
}
