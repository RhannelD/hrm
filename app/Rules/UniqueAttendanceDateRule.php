<?php

namespace App\Rules;

use App\Models\EmployeeAttendance;
use Illuminate\Contracts\Validation\Rule;

class UniqueAttendanceDateRule implements Rule
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
        $employee_attendace = EmployeeAttendance::where('user_id', $this->employee_id)
            ->where('start_at', '<=', $value)
            ->where('end_at', '>=', $value)
            ->first();

        return is_null($employee_attendace);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has a record already on attendances and leaves';
    }
}
