<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-mid-bar border-bottom-0 pb-1">
		<div class="input-group col-md-6 mb-1 px-0">
			<div class="input-group rounded">
				<input type="search" class="form-control rounded btn-white border-white" placeholder="Search Position" wire:model.debounce.1000ms='search'/>
				<span wire:click='$refresh' class="input-group-text bg-white border-0 ml-1">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>

        @can('create', \App\Models\Position::class)
            <div class="col-md-6 mb-1 px-0">
                <div class="input-group rounded">
                    <button onclick="unset_position()" class="btn btn-secondary ml-auto mr-0" type="button" data-toggle="modal" data-target="#position-modal">
                        <i class="fas fa-plus-circle"></i>
                        Create Position
                    </button>
                </div>
            </div>
        @endcan
	</nav>

    <div class="row mx-1">
		<div class="contents-container col-12">
			@include('livewire.position.position-search')
		</div>
	</div>

    @can('create', \App\Models\Position::class)
        <div wire:ignore>
            @livewire('position.position-edit-livewire'))
        </div>
    @endcan

    <script>
		window.addEventListener('position-modal', event => {
			$("#position-modal").modal(event.detail.action);
		});

        window.addEventListener('swal:confirm:delete_position', event => { 
            swal({
				title: event.detail.message,
				text: event.detail.text,
				icon: event.detail.type,
				buttons: true,
				dangerMode: true,
            }).then((willDelete) => {
				if (willDelete) {
					@this.delete_position(event.detail.position_id)
				}
            });
        });
    </script>
</div>
