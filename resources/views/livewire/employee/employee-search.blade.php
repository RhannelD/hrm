<div>
    @if ( count($employees) )
        <div class="d-flex justify-content-end mt-2">
            {{ $employees->links() }}
        </div> 
    @endif

    <div class="table-responsive mb-3 mt-2">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($employees as $employee)
                    <tr class="rows {{ session()->has("user-{$employee->id}")? session("user-{$employee->id}"): '' }}">
                        <th>
                            {{ ( ($loop->index + 1) + ( ($row_num * $page ) - $row_num) ) }}
                        </th>
                        <td class="text-nowrap">
                            {{ $employee->flname() }}
                        </td>
                        <td class="text-nowrap">
                            {{ $employee->email }}
                        </td>
                        <td class="text-nowrap">
                            {{ isset($employee->employee_position)? $employee->employee_position->department->department: 'N/A' }}
                        </td>
                        <td class="text-nowrap">
                            {{ isset($employee->employee_position)? $employee->employee_position->position->position: 'N/A' }}
                        </td>
                        <td class="text-center text-nowrap py-1">
                            <button class="btn btn-primary text-white">
                                <i class="fas fa-file-alt"></i>
                            </button>

                            @if( Auth::user()->can('update', $employee) )
                                <button onclick="set_user({{ $employee->id }})" class="btn btn-secondary" type="button" data-toggle="modal" data-target="#user-modal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                                
                            @can( 'delete', $employee )
                                <button wire:click='delete_confirm({{ $employee->id }})' class="btn btn-danger"  id="delete-{{ $employee->id }}"
                                    wire:loading.attr="disabled"
                                    wire:target="delete_user, delete_confirm"
                                    >
                                    <i class="fas fa-trash"
                                        wire:loading.remove
                                        wire:target="delete_user({{ $employee->id }})"
                                        >
                                    </i>
                                    <i class="fas fa-circle-notch fa-spin"
                                        wire:loading
                                        wire:target="delete_user({{ $employee->id }})"
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
