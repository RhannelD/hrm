<div>
    @if ( count($attendances) )
        <div class="d-flex justify-content-end mt-2">
            {{ $attendances->links() }}
        </div> 
    @endif

    <div class="table-responsive mb-3 mt-2">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Attendance/Leave</th>
                    <th>Payment</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($attendances as $attendance)
                    <tr class="rows {{ session()->has("employee_attendance-{$attendance->id}")? session("employee_attendance-{$attendance->id}"): '' }}">
                        <th>
                            {{ ( ($loop->index + 1) + ( ($row_num * $page ) - $row_num) ) }}
                        </th>
                        <td class="text-nowrap">
                            {{ $attendance->attendance->attendance }}
                        </td>
                        <td class="text-nowrap">
                            {{ $attendance->attendance->payment }}%
                        </td>
                        <td class="text-nowrap">
                            {{ \Carbon\Carbon::parse($attendance->start_at)->format('M d, Y') }}
                        </td>
                        <td class="text-nowrap">
                            {{ \Carbon\Carbon::parse($attendance->end_at)->format('M d, Y') }}
                        </td>
                        <td class="text-center text-nowrap py-1">
                            <a href="{{ route('employee.attendance.show', $attendance->id) }}" class="btn btn-primary text-white">
                                <i class="fas fa-file-alt"></i>
                            </a>

                            {{-- @if( Auth::user()->can('update', $employee) )
                                <button onclick="set_user({{ $employee->id }})" class="btn btn-secondary" type="button" data-toggle="modal" data-target="#user-modal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif --}}
                                
                            @can( 'delete', $attendance )
                                <button wire:click='delete_confirm({{ $attendance->id }})' class="btn btn-danger"  id="delete-{{ $attendance->id }}"
                                    wire:loading.attr="disabled"
                                    wire:target="delete_user, delete_confirm"
                                    >
                                    <i class="fas fa-trash"
                                        wire:loading.remove
                                        wire:target="delete_user({{ $attendance->id }})"
                                        >
                                    </i>
                                    <i class="fas fa-circle-notch fa-spin"
                                        wire:loading
                                        wire:target="delete_user({{ $attendance->id }})"
                                        >
                                    </i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-nowrap" colspan="10">
                            No Results
                        </td>
                    </tr>
                @endforelse 
            </tbody>
        </table> 
    </div>
</div>
