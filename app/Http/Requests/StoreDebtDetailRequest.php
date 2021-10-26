<?php

namespace App\Http\Requests;

use App\Enums\BankType;
use App\Enums\DebtDetailType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDebtDetailRequest extends FormRequest
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
            'number' => [
                'required'
            ],
            'date' => [
                'required',
                'date'
            ],
            'notes' => [
                'nullable',
            ],
            'amount' => [
                'required',
                'numeric'
            ],
            'paidFromBank' => [
                'nullable',
                Rule::in(BankType::asArray()),
            ],
            'type' => [
                'required',
                Rule::in(DebtDetailType::asArray()),
            ],
            'secondNote' => [
                'nullable'
            ]
        ];
    }
}
