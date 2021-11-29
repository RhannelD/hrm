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
                <tbody class="h5">
                    <tr>
                        <td class="text-right col-4">Employee:</td>
                        <td>
                            {{ $employee_attendance->user->flname() }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Email:</td>
                        <td>
                            {{ $employee_attendance->user->email }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Attendance:</td>
                        <td>
                            {{ $employee_attendance->attendance->attendance }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Description:</td>
                        <td>
                            {{ isset($employee_attendance->description)? $employee_attendance->description: 'N/A' }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Payment:</td>
                        <td>
                            {{ $employee_attendance->attendance->payment }}%
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Start Date:</td>
                        <td>    
                            {{ \Carbon\Carbon::parse($employee_attendance->start_at)->format('M d, Y') }}
                        </td>
                    </tr>
                    <tr> 
                        <td class="text-right">Start Date:</td>
                        <td>
                            {{ \Carbon\Carbon::parse($employee_attendance->end_at)->format('M d, Y') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="py-0">
                            <div class="d-flex justify-content-end py-1">
                                <a href="{{ route('employee.attendance', $employee_attendance->user->id) }}" class="btn btn-lg text-white btn-info ml-1" >
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
