<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-mid-bar border-bottom-0 pb-1">
		<div class="input-group col-md-6 mb-1 px-0">
			<h4 class="my-auto font-weight-bold text-white">
                Employee Performance
            </h4>
		</div>

        <div class="col-md-6 mb-1 px-0 d-flex justify-content-end">
            <div class="d-flex">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white border-0">Month</span>
                    </div>
                    <input wire:model="date" class="form-control border-0 font-weight-bold" type="month" name="month" id="month" onchange="datepicked();">
                </div>
            </div>
        </div>
	</nav>

    <div class="container-fluid mt-3 px-3">
        <div class="row">
            <div class="col-lg-6 px-2">
                @include('livewire.employee.performance.employee-details')
    
                <div class="card card-body p-2 mt-3 mb-3 border-{{ isset($payroll)? 'success': 'dark' }}">
                    @if ( isset($payroll) )
                        <h5 class="m-2 text-center font-weight-bold">
                            <i class="fas fa-check-circle"></i>
                            Payrolled at {{ \Carbon\Carbon::parse($payroll->updated_at)->format('Y-m-d h:i:s') }}
                        </h5>
                    @else
                        <div class="d-flex">
                            <button wire:click="payroll_confirm" class="btn btn-success text-nowrap"
                                wire:loading.attr="disabled"
                                wire:target="payroll_confirm, payroll"
                                >
                                <i class="fas fa-circle-notch fa-spin"
                                    wire:loading
                                    wire:target="payroll"
                                    >
                                </i>
                                Payroll
                            </button>
                            <div class="d-flex justify-content-end w-100">
                                <h5 class="my-auto">
                                    {{ \Carbon\Carbon::parse($date)->format("F Y") }}
                                </h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    
            <div class="col-lg-6 px-2">
                <div class="row mx-0">
                    <div class="col-6 px-1">
                        @include('livewire.employee.performance.employee-attendances')
                    </div>
                    <div class="col-6 px-1">
                        @include('livewire.employee.performance.employee-leaves')
                    </div>
                </div>

                @include('livewire.employee.performance.employee-salary')
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('swal:confirm:payroll_confirm', event => { 
            swal({
				title: event.detail.message,
				text: event.detail.text,
				icon: event.detail.type,
				buttons: true,
				dangerMode: true,
            }).then((willDelete) => {
				if (willDelete) {
					@this.payroll()
				}
            });
        });
    </script>
</div>
