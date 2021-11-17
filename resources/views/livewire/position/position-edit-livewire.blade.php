<div>
    <div wire:ignore.self class="modal fade" id="position-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="position-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="position-modal-label">
                        Position {{ isset($position_id)? 'Editing': 'Creating' }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info w-100" wire:loading.delay wire:target='set_position, unset_position'>
                        <i class="fas fa-circle-notch fa-spin"></i>
                        Loading...
                    </div>
                    <div class="form-group" wire:loading.remove wire:target='set_position, unset_position'>
                        <label for="position">Position</label>
                        <input wire:model.lazy='position.position' type="text" class="form-control" id="position" placeholder="Position">
                        @error('position.position') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group" wire:loading.remove wire:target='set_position, unset_position'>
                        <label for="position">Position</label>
                        <input wire:model.lazy='position.salary' type="number" class="form-control" id="position" placeholder="Salary">
                        @error('position.salary') <span class="text-danger">{{ $message }}</span> @enderror
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
        function set_position($course_id) {
            @this.set_position($course_id);
        }
        function unset_position() {
            @this.unset_position();
        }
    </script>
</div>
