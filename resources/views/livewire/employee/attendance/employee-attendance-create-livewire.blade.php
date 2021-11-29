<div>
    <div wire:ignore.self class="modal fade" id="employee-attendance-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="employee-attendance-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="employee-attendance-modal-label">
                        Add Employee Attendance/Leave
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info w-100" wire:loading.delay wire:target='set_department, unset_department'>
                        <i class="fas fa-circle-notch fa-spin"></i>
                        Loading...
                    </div>
                    <div wire:loading.remove wire:target='set_department, unset_department'>
                        <div class="form-group mb-2" >
                            <label class="mb-1">Employee</label>
                            <input type="text" class="form-control bg-white border-dark text-dark" readonly value="{{ $employee->flname() }}">
                        </div>
                        <div class="form-group">
                            <label for="c_attendance">Attendance/Leave</label>
                            <select wire:model="attendance" class="form-control" id="c_attendance">
                                <option>Select Attendance/Leave</option>
                                @foreach ($attendances as $attendance_data)
                                    <option value="{{ $attendance_data->id }}">{{ $attendance_data->attendance }}</option>
                                @endforeach
                            </select>
                            @error('attendance') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control bg-white" id="start_date"
                                wire:model.lazy="start_date">
                            @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control bg-white" id="end_date"
                                wire:model.lazy="end_date">
                            @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="c_description">Description</label>
                            <textarea wire:model.lazy="description" class="form-control" id="c_description" rows="2"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button wire:click="save" wire:loading.attr="disabled" type="button" class="btn btn-primary">
                        <i class="fas fa-save"
                            wire:loading.remove
                            wire:target="save"
                            >
                        </i>
                        <i class="fas fa-circle-notch fa-spin"
                            wire:loading
                            wire:target="save"
                            >
                        </i>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function reset_create() {
            @this.reset_create();
        }
    </script>
</div>
