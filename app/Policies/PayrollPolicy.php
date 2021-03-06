<?php

namespace App\Policies;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayrollPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Payroll $payroll)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, User $employee)
    {
        return $user->is_admin()
            || (
                $employee->employee_position->department_id == $user->employee_position->department_id
                && $user->employee_position->position_id == 1
            );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Payroll $payroll)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Payroll $payroll)
    {
        return $user->is_admin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Payroll $payroll)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Payroll $payroll)
    {
        //
    }
}
