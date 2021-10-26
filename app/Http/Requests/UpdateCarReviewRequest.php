<?php

namespace App\Http\Requests;

use App\Enums\CarReviewType;
use App\Rules\Car\MinMileage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarReviewRequest extends FormRequest
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
            'agent' => [
                'required',
            ],
            'date' => [
                'required',
                'date'
            ],
            'invoiceDate' => [
                'required', 'date'
            ],
            'type' => [
                'required',
                Rule::in(CarReviewType::getValues())
            ],
            'mileage' => [
                'required',
                new MinMileage,
            ],
            'amount' => [
                'required'
            ],
            'observations' => [
                'nullable'
            ]
        ];
    }
}
