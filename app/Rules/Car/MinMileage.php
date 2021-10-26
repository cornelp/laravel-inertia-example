<?php

namespace App\Rules\Car;

use App\Models\CarReview;
use Illuminate\Contracts\Validation\Rule;

class MinMileage implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = intval($value);

        $query = CarReview::whereCarId(
            is_int($car = request()->car) ? $car : $car->id
        );

        // get latest before date
        $latestBeforeDate = $query->where('date', '<=', now()->parse(request('date')))
            ->orderBy('date', 'DESC')
            ->first(['mileage']);

        // if this is the first record, allow it
        if (!$latestBeforeDate) {
            return true;
        }

        if (intval($latestBeforeDate->mileage) > $value) {
            return false;
        }

        // get latest after date
        $latestAfterDate = $query->where('date', '>=', now()->parse(request('date')))
            ->orderBy('date', 'DESC')
            ->first(['mileage']);

        if ($latestAfterDate?->mileage > 0 && intval($latestAfterDate?->mileage) < $value) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.review.min_mileage');
    }
}
