<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\SignInLivewire;
use App\Http\Livewire\Leave\LeaveLivewire;
use App\Http\Livewire\Employee\EmployeeLivewire;
use App\Http\Livewire\Position\PositionLivewire;
use App\Http\Livewire\Attendance\AttendanceLivewire;
use App\Http\Livewire\Department\DepartmentLivewire;

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
    Route::get('/employee', EmployeeLivewire::class)->name('employee');

    Route::get('/department', DepartmentLivewire::class)->name('department');

    Route::get('/position', PositionLivewire::class)->name('position');

    Route::get('/attendance', AttendanceLivewire::class)->name('attendance');

    Route::get('/leave', LeaveLivewire::class)->name('leave');
});

Route::get('/logout', function () { 
    return Auth::logout(); 
})->name('logout');
