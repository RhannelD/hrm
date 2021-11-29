<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\SignInLivewire;
use App\Http\Livewire\Leave\LeaveLivewire;
use App\Http\Livewire\Leave\LeaveShowLivewire;
use App\Http\Livewire\Profile\ProfileLivewire;
use App\Http\Livewire\Employee\EmployeeLivewire;
use App\Http\Livewire\Position\PositionLivewire;
use App\Http\Livewire\Attendance\AttendanceLivewire;
use App\Http\Livewire\Department\DepartmentLivewire;
use App\Http\Livewire\Employee\EmployeeShowLivewire;
use App\Http\Livewire\Position\PositionShowLivewire;
use App\Http\Livewire\Attendance\AttendanceShowLivewire;
use App\Http\Livewire\Department\DepartmentShowLivewire;
use App\Http\Livewire\Employee\Attendance\EmployeeAttendanceLivewire;
use App\Http\Livewire\Employee\Attendance\EmployeeAttendanceShowLivewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return redirect()->route('login.index'); })->name('index');


// Needs to be signed out to access
Route::group(['middleware' => ['guest']], function(){
    Route::get('/login', SignInLivewire::class)->name('login.index');
});

// Needs to be signed in to access
Route::group(['middleware' => ['auth']], function(){
    Route::prefix('/employee')->group(function () {
        Route::get('/', EmployeeLivewire::class)->name('employee');

        Route::get('/{employee_id}', EmployeeShowLivewire::class)->name('employee.show');

        Route::get('/{employee_id}/attendance', EmployeeAttendanceLivewire::class)->name('employee.attendance');

        Route::get('/attendance/{attendance_id}', EmployeeAttendanceShowLivewire::class)->name('employee.attendance.show');
	});

    Route::get('/department', DepartmentLivewire::class)->name('department');
    Route::get('/department/{department_id}', DepartmentShowLivewire::class)->name('department.show');

    Route::get('/position', PositionLivewire::class)->name('position');
    Route::get('/position/{position_id}', PositionShowLivewire::class)->name('position.show');

    Route::get('/attendance', AttendanceLivewire::class)->name('attendance');
    Route::get('/attendance/{attendance_id}', AttendanceShowLivewire::class)->name('attendance.show');

    Route::get('/leave', LeaveLivewire::class)->name('leave');
    Route::get('/leave/{leave_id}', LeaveShowLivewire::class)->name('leave.show');

    Route::get('/profile', ProfileLivewire::class)->name('profile');
});
