<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-mid-bar border-bottom-0 pb-1">
        <div class="input-group col-md-4 mb-1 px-0">
            <a href="{{ route('employee.show', $employee_id) }}">
			    <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-0 bg-primary font-weight-bold text-white" id="employee-name">Employee</span>
                    </div>
                    <input type="text" class="form-control border-0 bg-white" readonly aria-label="Username" aria-describedby="employee-name" value="{{ $employee->flname() }}">
                </div>
            </a>
		</div>

        <div class="col-md-8 mb-1 px-0 d-flex justify-content-end flex-wrap flex-md-nowrap">
            <div class="d-flex" style="min-width: 100px">
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded btn-white border-white" placeholder="Search Attendance/Leave" wire:model.debounce.1000ms='search'/>
                    <span wire:click='$refresh' class="input-group-text bg-white border-0 ml-1">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <div class="d-flex ml-3">
                <div class="input-group rounded">
                    <button onclick="reset_create()" class="btn btn-secondary ml-auto mr-0 text-nowrap" type="button" data-toggle="modal" data-target="#employee-attendance-modal">
                        <i class="fas fa-plus-circle"></i>
                        Add New Attendance/Leave
                    </button>
                </div>
            </div>
        </div>
	</nav>
    
    <div class="row mx-1">
		<div class="contents-container col-12">
			@include('livewire.employee.attendance.employee-attendance-search')
		</div>
	</div>

    <div wire:ignore>
        @livewire('employee.attendance.employee-attendance-create-livewire', ['employee_id' => $employee_id]))
    </div>

    <script>
		window.addEventListener('employee-attendance-modal', event => {
			$("#employee-attendance-modal").modal(event.detail.action);
		});

        window.addEventListener('swal:confirm:delete_employee_attendance', event => { 
            swal({
				title: event.detail.message,
				text: event.detail.text,
				icon: event.detail.type,
				buttons: true,
				dangerMode: true,
            }).then((willDelete) => {
				if (willDelete) {
					@this.delete_employee_attendance(event.detail.employee_attendance_id)
				}
            });
        });
    </script>
</div>
