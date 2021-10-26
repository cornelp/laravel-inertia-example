<?php

namespace App\Http\Requests;

use App\Enums\AreaType;
use App\Enums\CarModelType;
use App\Enums\CarType;
use App\Enums\CityType;
use App\Enums\FuelType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
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
                Rule::in(AreaType::getValues())
            ],
            'city' => [
                'required',
                Rule::in(CityType::getValues())
            ],
            'licenseNo' => [
                'required',
                Rule::unique('cars', 'license_no')->ignore($this->car->licenseNo, 'license_no'),
            ],
            'model' => [
                'required',
                Rule::in(CarModelType::getValues())
            ],
            'agent' => [
                'nullable',
            ],
            'fuel' => [
                Rule::in(FuelType::getValues())
            ],
            'productionYear' => [
                'required'
            ],
            'purchaseYear' => [
                'required'
            ],
            'type' => [
                'required',
                Rule::in(CarType::getValues())
            ],
            'engineCapacity' => [],
            'revisionInKm' => [],
            'horsePower' => [],
            'chassis' => [
                'required',
                Rule::unique('cars', 'chassis')->ignore($this->car->chassis, 'chassis')
            ],
            'fuelCard' => [],
            'fuelPin' => [],
            'needsRoadTax' => [
                'required',
                'boolean'
            ],
            'distributionInYears' => [],
            'distributionInKm' => [],
        ];
    }
}
