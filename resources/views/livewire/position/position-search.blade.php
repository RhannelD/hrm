<div>
    @if ( count($positions) )
        <div class="d-flex justify-content-end mt-2">
            {{ $positions->links() }}
        </div> 
    @endif

    <div class="table-responsive mb-3 mt-2">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Position</th>
                    <th class="text-nowrap text-right">Salary/Day</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($positions as $position)
                    <tr class="rows {{ session()->has("position-{$position->id}")? session("position-{$position->id}"): '' }}">
                        <th>
                            {{ ( ($loop->index + 1) + ( ($row_num * $page ) - $row_num) ) }}
                        </th>
                        <td class="text-nowrap">
                            {{ $position->position }}
                        </td>
                        <td class="text-nowrap text-right">
                            {{ $position->salary }}
                        </td>
                        <td class="text-center text-nowrap py-1">
                            @can( 'update', $position )
                                <button onclick="set_position({{ $position->id }})" class="btn btn-secondary" type="button" data-toggle="modal" data-target="#position-modal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endcan
                                
                            @can( 'delete', $position )
                                <button wire:click='delete_confirm({{ $position->id }})' class="btn btn-danger"  id="delete-{{ $position->id }}"
                                    wire:loading.attr="disabled"
                                    wire:target="delete_position, delete_confirm"
                                    >
                                    <i class="fas fa-trash"
                                        wire:loading.remove
                                        wire:target="delete_position({{ $position->id }})"
                                        >
                                    </i>
                                    <i class="fas fa-circle-notch fa-spin"
                                        wire:loading
                                        wire:target="delete_position({{ $position->id }})"
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
