<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-mid-bar border-bottom-0 pb-1">
		<div class="input-group col-md-6 mb-1 px-0">
			<h4 class="my-auto font-weight-bold text-white">
                @if ( isset($employee) )
                    {{ $employee->flname() }} - Payrolls
                @else
                    Payrolls 
                @endif
            </h4>
		</div>

        <div class="col-md-6 mb-1 px-0 d-flex justify-content-end">
            <div class="d-flex">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white border-0">Month</span>
                    </div>
                    <input wire:model="date" class="form-control border-0 font-weight-bold" type="month" name="month" id="month" onchange="datepicked();">
                    <div class="input-group-append">
                        <button wire:click="$set('date', null)" class="btn btn-success" type="button">
                            View All
                        </button>
                      </div>
                </div>
            </div>
        </div>
	</nav>

    <div class="row mx-1">
		<div class="contents-container col-12">
			@include('livewire.payroll.payroll-search')
		</div>
	</div>
    
    <script>
        window.addEventListener('swal:confirm:delete_payroll', event => { 
            swal({
				title: event.detail.message,
				text: event.detail.text,
				icon: event.detail.type,
				buttons: true,
				dangerMode: true,
            }).then((willDelete) => {
				if (willDelete) {
					@this.delete_payroll(event.detail.payroll_id)
				}
            });
        });
    </script>
</div>
