<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-mid-bar border-bottom-0 pb-1">
		<div class="input-group col-md-6 mb-1 px-0">
			<div class="input-group rounded">
				<input type="search" class="form-control rounded btn-white border-white" placeholder="Search Leave" wire:model.debounce.1000ms='search'/>
				<span wire:click='$refresh' class="input-group-text bg-white border-0 ml-1">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>

        @can('create', \App\Models\Attendance::class)
            <div class="col-md-6 mb-1 px-0">
                <div class="input-group rounded">
                    <button onclick="unset_attendance()" class="btn btn-secondary ml-auto mr-0" type="button" data-toggle="modal" data-target="#attendance-modal">
                        <i class="fas fa-plus-circle"></i>
                        Create Leave
                    </button>
                </div>
            </div>
        @endcan
	</nav>

    <div class="row mx-1">
		<div class="contents-container col-12">
			@include('livewire.leave.leave-search')
		</div>
	</div>

    @can('create', \App\Models\Department::class)
        <div wire:ignore>
            @livewire('leave.leave-edit-livewire'))
        </div>
    @endcan

    <script>
		window.addEventListener('attendance-modal', event => {
			$("#attendance-modal").modal(event.detail.action);
		});

        window.addEventListener('swal:confirm:delete_attendance', event => { 
            swal({
				title: event.detail.message,
				text: event.detail.text,
				icon: event.detail.type,
				buttons: true,
				dangerMode: true,
            }).then((willDelete) => {
				if (willDelete) {
					@this.delete_attendance(event.detail.course_id)
				}
            });
        });
    </script>
</div>