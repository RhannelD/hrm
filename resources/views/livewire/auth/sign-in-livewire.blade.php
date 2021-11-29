<div class="h-100">
<div class="p-0 p-sm-2 p-md-3 p-1 h-100 login-bg">
    <div class="card border-0 overflow-hidden h-100 rounded-lg login-panel shadow-lg rounded">
        <div class="row mx-0 h-100">
            <div class="offset-md-5 col-md-7 offset-lg-7 col-lg-5 h-100 bg-white">
                <div class="row h-100 align-items-center overflow-auto">
                    <div class="offset-md-1 col-md-10">

                        <img src="{{ asset('img/hrm-icon.png') }}" alt="" height="100px" class="mx-auto d-block mb-5 mt-2">

                        <form class="col-12 mb-5" wire:submit.prevent="signin()">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" wire:model.lazy="email" placeholder="juan.delacruz@g.batstate-u.edu.ph" required autocomplete="email" autofocus>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" wire:model.lazy="password" required placeholder="Password">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-2">
                                    <button wire:loading.attr='disabled' wire:target='signin' type="submit" class="btn btn-primary btn-block">
                                        <strong>
                                            Sign-in
                                        </strong>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <a href="#" type="button" data-toggle="modal" data-target="#forgot-password">
                                    <h6>
                                        Forgot password
                                    </h6>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
@livewire('auth.forgot-password-livewire', key('forgot-password'))
</div>
