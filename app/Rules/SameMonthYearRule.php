<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class SameMonthYearRule implements Rule
{
    public $start_date;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $end_date)
    {
        $this->date1name = str_replace('_', ' ', $attribute);
        $date1 = $end_date;
        $date2 = $this->start_date;

        $date1 = Carbon::parse($date1)->format('Y-m');
        $date2 = Carbon::parse($date2)->format('Y-m');

        return $date1==$date2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Month and Year of Start Date and End Date must be similar!';
    }
}
