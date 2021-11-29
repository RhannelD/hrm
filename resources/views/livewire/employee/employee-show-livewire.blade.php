<div class="contents-container col-md-10 offset-md-1">
    <div class="container">
        <div class="container card card-body my-5 p-4" id="form">
            <table class="table table-striped my-0" id="table-info">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center bg-dark text-white">
                            <h1 class="my-auto font-weight-bold">
                                Employee Information
                            </h1>
                        </th>
                    </tr>
                </thead>
                <tbody class="h4">
                    <tr>
                        <td class="text-right col-4">Leave:</td>
                        <td>
                            {{ $employee->flname() }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Email:</td>
                        <td>
                            {{ $employee->email }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Sex:</td>
                        <td class="text-capitalize">
                            {{ $employee->gender }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Department:</td>
                        <td>
                            {{ isset($employee->employee_position)? $employee->employee_position->department->department: 'N/A' }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Position:</td>
                        <td>
                            {{ isset($employee->employee_position)? $employee->employee_position->position->position: 'N/A' }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="py-0">
                            <div class="d-flex justify-content-end py-1">
                                <a href="{{ route('employee.performance', $employee->id) }}" class="btn btn-lg text-white btn-info ml-1">
                                    Performance
                                </a>
                                <a href="{{ route('employee.attendance', $employee->id) }}" class="btn btn-lg text-white btn-info ml-1">
                                    Attendance/Leave
                                </a>
                                <a href="{{ route('employee') }}" class="btn btn-lg text-white btn-info ml-1" >
                                    Back
                                </a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
