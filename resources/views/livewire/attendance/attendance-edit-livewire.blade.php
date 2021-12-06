<div>
    <div wire:ignore.self class="modal fade" id="attendance-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="attendance-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="attendance-modal-label">
                        Attendance {{ isset($attendance_id)? 'Editing': 'Creating' }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info w-100" wire:loading.delay wire:target='set_attendance, unset_attendance'>
                        <i class="fas fa-circle-notch fa-spin"></i>
                        Loading...
                    </div>
                    <div wire:loading.remove wire:target='set_attendance, unset_attendance'>
                        <div class="form-group" >
                            <label for="attendance">Attendance</label>
                            <input wire:model.lazy='attendance.attendance' type="text" class="form-control" id="attendance" placeholder="Attendance">
                            @error('attendance.attendance') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" >
                            <label for="payment">Payment</label>
                            
                            <div class="input-group mb-3">
                                <input wire:model.lazy='attendance.payment' type="text" class="form-control" id="payment" placeholder="Payment in %" aria-describedby="payment-addon">
                                <div class="input-group-append">
                                  <span class="input-group-text" id="payment-addon">%</span>
                                </div>
                            </div>
                            @error('attendance.payment') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea wire:model.lazy='attendance.description' class="form-control" id="description" rows="3" placeholder="Description"></textarea>
                            @error('attendance.description') <span class="text-danger">{{ $message }}</span> @enderror
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
        function set_attendance($attendance_id) {
            @this.set_attendance($attendance_id);
        }
        function unset_attendance() {
            @this.unset_attendance();
        }
    </script>
</div>
