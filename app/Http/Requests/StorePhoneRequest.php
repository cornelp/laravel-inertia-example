<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePhoneRequest extends FormRequest
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
                'required',
                Rule::unique('phones'),
            ],
            'serial' => [
                'required',
                Rule::unique('phones'),
            ],
            'agent' => [
                'nullable',
            ],
            'notes' => [
                'nullable'
            ],
            'isActive' => [
                'nullable',
                'boolean'
            ],
        ];
    }
}
