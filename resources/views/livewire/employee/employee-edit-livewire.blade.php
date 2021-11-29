<div>
    <div wire:ignore.self class="modal fade" id="user-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="user-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="user-modal-label">
                        Employee {{ isset($user_id)? 'Editing': 'Creating' }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info w-100" wire:loading.delay wire:target='set_user, unset_user'>
                        <i class="fas fa-circle-notch fa-spin"></i>
                        Loading...
                    </div>

                    <div class="form-row" wire:loading.remove wire:target='set_user, unset_user'>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="c_firstname">First Name</label>
                                <input type="text" wire:model.lazy="user.firstname" class="form-control" id="c_firstname" placeholder="First Name">
                                @error('user.firstname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="c_lastname">Last Name</label>
                                <input type="text" wire:model.lazy="user.lastname" class="form-control" id="c_lastname" placeholder="Last Name">
                                @error('user.lastname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>Sex</label>
                                <select class="form-control" wire:model.lazy="user.gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('user.gender') <span class="text-danger">{{ $message }}</span> @enderror	
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="c_email">Email</label>
                                <input type="email" wire:model.lazy="user.email" class="form-control" id="c_email" placeholder="juan.delacruz.@g.batstate-u-edu.ph"
                                    @isset($disable_email)
                                        readonly
                                    @endisset
                                    >
                                @error('user.email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="c_course">Department</label>
                                <select wire:model="employee.department_id" class="form-control" id="c_course">
                                    <option>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                @error('employee.department_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="c_position">Position</label>
                                <select wire:model="employee.position_id" class="form-control" id="c_position">
                                    <option>Select Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->position }}</option>
                                    @endforeach
                                </select>
                                @error('employee.position_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if ( is_null($user_id) )
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="c_password">Password</label>
                                    <input type="password" wire:model.lazy="password" class="form-control" id="c_password" placeholder="Password">
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
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
            </form>
        </div>
    </div>

    <script>
        function set_user($course_id) {
            @this.set_user($course_id);
        }
        function unset_user() {
            @this.unset_user();
        }
    </script>
</div>
