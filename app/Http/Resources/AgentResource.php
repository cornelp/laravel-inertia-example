<?php

namespace App\Http\Resources;

use App\Enums\AreaType;
use App\Enums\CorType;
use App\Enums\PositionType;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'contractNo' => $this->contractNo,
            'area' => AreaType::getDescription($this->area),
            'hireDate' => $this->hireDate,
            'birthDate' => $this->birthDate,
            'cnp' => $this->cnp,
            'icSerial' => $this->icSerial,
            'icNumber' => $this->icNumber,
            'address' => $this->address,
            'icCity' => $this->icCity,
            'position' => PositionType::getDescription($this->position),
            'cor' => CorType::getDescription($this->cor),
            'resignationDate' => $this->resignationDate,
            'phone' => optional($this->phone)->number
        ];
    }
}
