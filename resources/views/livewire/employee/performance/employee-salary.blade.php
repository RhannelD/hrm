<div class="card mt-3 border-dark">
    <div class="card-header bg-dark">
        <h4 class="my-auto text-white text-center">
            Salary Details
        </h4>
    </div>
    <div class="card-body border-dark border-bottom py-2">
        <table class="table table-sm h5 table-borderless my-0">
            <tbody>
                <tr>
                    <td>
                        Daily Salary:
                    </td>
                    <td class="text-right">
                        ₱ {{ $salary_details->daily_salary }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Monthly Salary:
                    </td>
                    <td class="text-right">
                        ₱ {{ $salary_details->monthly_salary }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-body py-2">
        <table class="table table-sm h5 table-borderless my-2">
            <tbody>
                <tr>
                    <td>
                        Normal Days Salary:
                    </td>
                    <td class="text-right">
                        ₱ {{ $salary_details->normal_days_salary }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Attendance Salary:
                    </td>
                    <td class="text-right">
                        ₱ {{ $salary_details->attendance_salary }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Leave Salary:
                    </td>
                    <td class="text-right">
                        ₱ {{ $salary_details->leave_salary }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr class="my-1 border-dark">
                    </td>
                </tr>
                <tr>
                    <td>
                        Total Salary:
                    </td>
                    <td class="text-right">
                        ₱ {{ $salary_details->total_salary }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
