<?php

namespace App\Http\Resources;

use App\Enums\AreaType;
use App\Enums\CityType;
use App\Enums\DebtType;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtResource extends JsonResource
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
            'area' => AreaType::getDescription($this->area),
            'city' => CityType::getDescription($this->city),
            'name' => $this->name,
            'balance' => $this->balance,
            'invoicedAmount' => $this->invoicedAmount,
            'paidAmount' => $this->paidAmount,
            'notes' => $this->notes,
            'taxCode' => $this->taxCode,
            'bankAccount' => $this->bankAccount,
            'bank' => $this->bank,
            'type' => DebtType::getDescription($this->type),
            'isActive' => $this->isActive,
        ];
    }
}
