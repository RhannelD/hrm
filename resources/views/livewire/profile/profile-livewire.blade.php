<div class="mx-3 mt-5">
    <div class="card mw800 mx-auto border-dark">
        <div class="card-header bg-dark text-white">
            <h2 class="font-weight-bold my-auto text-center">
                Profile Information
            </h2>
        </div>
        @isset($user)
            <div class="container-fluid px-md-3 px-0 card-body">
                <div class="row h5">
                    <div class="col-auto">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    Name: 
                                </td>
                                <td>
                                    {{ $user->flname() }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email: 
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sex: 
                                </td>
                                <td>
                                    {{ Str::ucfirst($user->gender) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end card-footer">
                <button class="btn btn-primary" data-toggle="modal" data-target="#update-password-modal"
                    {{-- wire:click="$emitTo('user.change-password-livewire', 'reset_values')" --}}
                    >
                    Change Password
                </button>
            </div>
        @endisset
    </div>
    
    <div wire:ignore>
        @livewire('profile.update-password-livewire')
    </div>

    <script>
		window.addEventListener('change-password-form', event => {
			$("#update-password-modal").modal(event.detail.action);
		});
    </script>
</div>
