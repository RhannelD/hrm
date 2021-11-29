<div class="card border-dark">
    <div class="card-header bg-dark">
        <h4 class="my-auto text-white text-center">
            Employee Details
        </h4>
    </div>
    <div class="card-body">
        <table class="table-sm h5">
            <tbody>
                <tr>
                    <td class="text-right">
                        Name:
                    </td>
                    <td>
                        {{ $employee->flname() }}
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        Email:
                    </td>
                    <td>
                        {{ $employee->email }}
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        Gender:
                    </td>
                    <td class="text-capitalize">
                        {{ $employee->gender }}
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        Department:
                    </td>
                    <td>
                        {{ 
                            isset($payroll)? $payroll->department->department
                                : (isset($employee->employee_position)? $employee->employee_position->department->department: 'N/A') 
                        }}
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        Position:
                    </td>
                    <td>
                        {{ 
                            isset($payroll)? $payroll->position->position
                                : (isset($employee->employee_position)? $employee->employee_position->position->position: 'N/A') 
                        }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
