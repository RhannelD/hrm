<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Models\Payroll;
use Illuminate\Contracts\Validation\Rule;

class NotYetPayrolledDateRule implements Rule
{
    public $employee_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($employee_id)
    {
        $this->employee_id = $employee_id;
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
        $date = Carbon::parse($value);

        return !Payroll::where('user_id', $this->employee_id)
            ->whereYear('payroll_at', '=', $date->format('Y'))
            ->whereMonth('payroll_at', '=', $date->format('m'))
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has already been payrolled.';
    }
}
