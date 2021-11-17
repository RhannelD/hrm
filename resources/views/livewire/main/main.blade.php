@extends('layouts.app')


@section('main')

<div class="d-flex" id="wrapper">
@if ( Auth::check() )
    <!-- Sidebar -->
    <div class="bg-side-bar" id="sidebar-wrapper">
        <div class="sidebar-heading" style="font-size: 26px;">
            <img src="{{ asset('img/hrm-icon.png') }}" alt="" height="80px" class="mx-auto d-block mb-2">
        </div>

        <div class="list-group list-group-flush">  
            <a class="list-group-item list-group-item-action bg-side-bar bg-side-item-bar text-white border-white tabs" href="{{ route('employee') }}">
                <i class="fas fa-user-tie"></i>
                Employees
            </a> 
            <a class="list-group-item list-group-item-action bg-side-bar bg-side-item-bar text-white border-white tabs" href="{{ route('department') }}">
                <i class="fas fa-building"></i>
                Departments
            </a> 
            <a class="list-group-item list-group-item-action bg-side-bar bg-side-item-bar text-white border-white tabs" href="{{ route('position') }}">
                <i class="fas fa-address-card"></i>
                Positions
            </a> 
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-dark bg-top-bar border-bottom-0">
            <button onclick="menu_toggle()" class="btn btn-outline-secondary disabled" id="menu-toggle">
                <span class="navbar-toggler-icon"></span>
            </button>

            <button type="" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse1">
                <i class="fas fa-ellipsis-v"></i>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarCollapse1">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <strong>
                                {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }} 
                            </strong>
                        </a>

						<div class="dropdown-menu dropdown-menu-right dropdown-cyan" aria-labelledby="navbarDropdownMenuLink-4">
							<a class="dropdown-item" {{-- href=" route('my.account')  --}}}}">
                                <i class="fas fa-user-circle"></i>
                                Profile
                            </a>
                            @livewire('auth.sign-out-livewire')
						</div>
					</li>
				</ul>
            </div>
        </nav>

        <div class="container-fluid px-0" id="mainpanel">
            @yield('content')  
        </div>
    </div>   
@endif
</div>

@endsection
