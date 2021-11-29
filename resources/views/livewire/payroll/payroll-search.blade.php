<div>
    @if ( count($payrolls) )
        <div class="d-flex justify-content-end mt-2">
            {{ $payrolls->links() }}
        </div> 
    @endif

    <div class="table-responsive mb-3 mt-2">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Month</th>
                    <th class="text-center">Year</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payrolls as $payroll)
                    <tr class="rows">
                        <th>
                            {{ ( ($loop->index + 1) + ( ($row_num * $page ) - $row_num) ) }}
                        </th>
                        <td class="text-nowrap">
                            {{ $payroll->user->flname() }}
                        </td>
                        <td class="text-nowrap text-right">
                            ₱ {{ $payroll->total_salary }}
                        </td>
                        <td class="text-nowrap text-right">
                            {{ \Carbon\Carbon::parse($payroll->payroll_at)->format('F') }}
                        </td>
                        <td class="text-nowrap text-center">
                            {{ \Carbon\Carbon::parse($payroll->payroll_at)->format('Y') }}
                        </td>
                        <td class="text-center text-nowrap py-1">
                            <a href="{{ route('employee.performance', ['employee_id'=>$payroll->user->id, 'date'=>\Carbon\Carbon::parse($payroll->payroll_at)->format('Y-m')]) }}" class="btn btn-primary text-white">
                                <i class="fas fa-file-alt"></i>
                            </a>

                            @can( 'delete', $payroll )
                                <button wire:click='delete_confirm({{ $payroll->id }})' class="btn btn-danger"  id="delete-{{ $payroll->id }}"
                                    wire:loading.attr="disabled"
                                    wire:target="delete_payroll, delete_confirm"
                                    >
                                    <i class="fas fa-trash"
                                        wire:loading.remove
                                        wire:target="delete_payroll({{ $payroll->id }})"
                                        >
                                    </i>
                                    <i class="fas fa-circle-notch fa-spin"
                                        wire:loading
                                        wire:target="delete_payroll({{ $payroll->id }})"
                                        >
                                    </i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-nowrap" colspan="4">
                            No Results
                        </td>
                    </tr>
                @endforelse 
            </tbody>
        </table> 
    </div>
</div>
