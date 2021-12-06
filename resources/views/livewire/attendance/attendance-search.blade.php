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
                    <th>Attendance</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($attendances as $attendance)
                    <tr class="rows {{ session()->has("attendance-{$attendance->id}")? session("attendance-{$attendance->id}"): '' }}">
                        <th>
                            {{ ( ($loop->index + 1) + ( ($row_num * $page ) - $row_num) ) }}
                        </th>
                        <td class="text-nowrap">
                            {{ $attendance->attendance }}
                        </td>
                        <td class="text-center text-nowrap py-1">
                            <a href="{{ route('attendance.show', $attendance->id) }}" class="btn btn-primary text-white">
                                <i class="fas fa-file-alt"></i>
                            </a>

                            @can( 'update', $attendance )
                                <button onclick="set_attendance({{ $attendance->id }})" class="btn btn-secondary" type="button" data-toggle="modal" data-target="#attendance-modal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endcan
                                
                            @can( 'delete', $attendance )
                                <button wire:click='delete_confirm({{ $attendance->id }})' class="btn btn-danger"  id="delete-{{ $attendance->id }}"
                                    wire:loading.attr="disabled"
                                    wire:target="delete_attendance, delete_confirm"
                                    >
                                    <i class="fas fa-trash"
                                        wire:loading.remove
                                        wire:target="delete_attendance({{ $attendance->id }})"
                                        >
                                    </i>
                                    <i class="fas fa-circle-notch fa-spin"
                                        wire:loading
                                        wire:target="delete_attendance({{ $attendance->id }})"
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
