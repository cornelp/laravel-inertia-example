<?php

namespace App\Http\Requests;

use App\Enums\AreaType;
use App\Enums\CorType;
use App\Enums\PositionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAgentRequest extends FormRequest
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
            'contractNo' => [
                'required',
                Rule::unique('agents', 'contract_no')->ignore($this->agent->id)
            ],
            'name' => [
                'required',
                'min:1',
                'max:255'
            ],
            'area' => [
                'required',
                Rule::in(AreaType::asArray())
            ],
            'hireDate' => [
                'required',
                'date',
            ],
            'birthDate' => [
                'required',
                'date',
            ],
            'cnp' => ['required'],
            'icSerial' => ['required'],
            'icNumber' => ['required'],
            'icCity' => ['required'],
            'address' => ['nullable'],
            'position' => [
                'required',
                Rule::in(PositionType::asArray())
            ],
            'cor' => [
                'required',
                Rule::in(CorType::asArray())
            ],
            'resignationDate' => ['nullable'],
            'phone' => ['nullable']
        ];
    }
}
