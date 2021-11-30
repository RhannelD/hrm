<?php

namespace App\Policies;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payroll;
use App\Models\EmployeeAttendance;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeAttendancePolicy
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
     * @param  \App\Models\EmployeeAttendance  $employeeAttendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, EmployeeAttendance $employeeAttendance)
    {
        return $user->is_admin()
            || $user->id == $employeeAttendance->user_id
            || (
                $employee->employee_position->department_id == $user->employee_position->department_id
                && $user->employee_position->position_id == 1
            );
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
     * @param  \App\Models\EmployeeAttendance  $employeeAttendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, EmployeeAttendance $employeeAttendance)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmployeeAttendance  $employeeAttendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, EmployeeAttendance $employeeAttendance)
    {
        return $user->is_admin()
            || (
                $employeeAttendance->user->employee_position->department_id == $user->employee_position->department_id
                && $user->employee_position->position_id == 1
            );
    }

    /**
     * Determine whether the user can delete depending on payrolls.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmployeeAttendance  $employeeAttendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete_depending_on_payrolls(User $user, EmployeeAttendance $employeeAttendance)
    {
        $date = Carbon::parse($employeeAttendance->start_at);
        
        return !Payroll::where('user_id', $employeeAttendance->user_id)
            ->whereYear('payroll_at', '=', $date->format('Y'))
            ->whereMonth('payroll_at', '=', $date->format('m'))
            ->exists();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmployeeAttendance  $employeeAttendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, EmployeeAttendance $employeeAttendance)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmployeeAttendance  $employeeAttendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, EmployeeAttendance $employeeAttendance)
    {
        //
    }
}
