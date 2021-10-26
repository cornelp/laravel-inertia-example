<?php

namespace App\Http\Requests;

use App\Enums\AreaType;
use App\Enums\CityType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDebtRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'area' => [
                'required',
                Rule::in(AreaType::asArray())
            ],
            'city' => [
                'required',
                Rule::in(CityType::asArray())
            ],
            'name' => [
                'required'
            ],
            'notes' => [
                'nullable'
            ],
            'taxCode' => [
                'required',
            ],
            'bankAccount' => [
                'required',
                Rule::unique('debts', 'bank_account')->ignore($this->debt->id)
            ],
            'bank' => [
                'required'
            ],
            'isActive' => [
                'required',
                'boolean'
            ]
        ];
    }
}
