<div>
    @if ( count($departments) )
        <div class="d-flex justify-content-end mt-2">
            {{ $departments->links() }}
        </div> 
    @endif

    <div class="table-responsive mb-3 mt-2">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Department</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($departments as $department)
                    <tr class="rows {{ session()->has("department-{$department->id}")? session("department-{$department->id}"): '' }}">
                        <th>
                            {{ ( ($loop->index + 1) + ( ($row_num * $page ) - $row_num) ) }}
                        </th>
                        <td class="text-nowrap">
                            {{ $department->department }}
                        </td>
                        <td class="text-center text-nowrap py-1">
                            <a href="{{ route('department.show', $department->id) }}" class="btn btn-primary text-white">
                                <i class="fas fa-file-alt"></i>
                            </a>

                            @can( 'update', $department )
                                <button onclick="set_department({{ $department->id }})" class="btn btn-secondary" type="button" data-toggle="modal" data-target="#department-modal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endcan
                                
                            @can( 'delete', $department )
                                <button wire:click='delete_confirm({{ $department->id }})' class="btn btn-danger"  id="delete-{{ $department->id }}"
                                    wire:loading.attr="disabled"
                                    wire:target="delete_department, delete_confirm"
                                    >
                                    <i class="fas fa-trash"
                                        wire:loading.remove
                                        wire:target="delete_department({{ $department->id }})"
                                        >
                                    </i>
                                    <i class="fas fa-circle-notch fa-spin"
                                        wire:loading
                                        wire:target="delete_department({{ $department->id }})"
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
