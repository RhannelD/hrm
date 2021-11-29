<div class="card border-dark">
    <div class="card-header bg-dark">
        <h4 class="my-auto text-white text-center">
            Leaves
        </h4>
    </div>
    <div class="card-body p-3">
        <table class="table table-sm table-borderless h5 mb-0">
            <tbody>
                @forelse ($leaves as $leave)
                    <tr>
                        <td>
                            {{ $leave->attendance }}:
                        </td>
                        <td class="text-right">
                            {{ $leave->employee_attendances->count() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            N/A
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
