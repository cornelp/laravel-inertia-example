<?php

namespace App\Http\Resources;

use App\Enums\BankType;
use App\Enums\DebtDetailType;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtDetailResource extends JsonResource
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
            'debtId' => $this->debtId,
            'number' => $this->number,
            'date' => $this->date->toIsoString(),
            'amount' => $this->amount,
            'paidFromBank' => $this->paidFromBank ? BankType::getDescription($this->paidFromBank) : null,
            'type' => DebtDetailType::getDescription($this->type),
            'secondNote' => $this->secondNote,
        ];
    }
}
