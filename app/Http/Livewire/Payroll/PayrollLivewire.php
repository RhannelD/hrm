<?php

namespace App\Http\Livewire\Payroll;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payroll;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PayrollLivewire extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $employee_id;

    public $date;
    public $row_num = 10;

    public function mount($employee_id = null)
    {
        $this->employee_id = $employee_id;
    }

    public function render()
    {
        return view('livewire.payroll.payroll-livewire', [
                'employee' => $this->get_employee(),
                'payrolls' => $this-> get_payrolls(),
            ])
            ->extends('livewire.main.main');
    }

    protected function get_employee()
    {
        return User::find($this->employee_id);
    }

    protected function get_payrolls()
    {
        $employee_id = $this->employee_id;
        $date = isset($this->date)? Carbon::parse($this->date): null;
        return Payroll::when(isset($date), function ($query) use ($date) {
                $query->whereYear('payroll_at', '=', $date->format('Y'))
                ->whereMonth('payroll_at', '=', $date->format('m'));
            })
            ->when(isset($employee_id), function ($query) use ($employee_id) {
                $query->where('user_id', $employee_id);
            })
            ->when(!Auth::user()->is_admin() && Auth::user()->can_payroll(), function ($query) {
                $query->where('department_id', Auth::user()->employee_position->department_id);
            })
            ->when(!Auth::user()->is_admin() && !Auth::user()->can_payroll(), function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('payroll_at', 'desc')
            ->paginate($this->row_num);
    }

    protected function get_payroll($payroll_id)
    {
        return Payroll::find($payroll_id);
    }
    
    public function delete_confirm($payroll_id)
    {
        if ( Auth::guest() || Auth::user()->cannot('delete', $this->get_payroll($payroll_id)) ) 
            return;
        
        $this->dispatchBrowserEvent('swal:confirm:delete_payroll', [
            'type' => 'warning',  
            'message' => 'Are you sure?', 
            'text' => 'If deleted, you will not be able to recover this payroll!',
            'payroll_id' => $payroll_id,
        ]);
    }

    public function delete_payroll($payroll_id)
    {
        $payroll = $this->get_payroll($payroll_id);
        if ( Auth::guest() || Auth::user()->cannot('delete', $payroll) ) 
            return;

        if ( $payroll->delete() ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Payroll Deleted', 
                'text' => 'Payroll has been successfully deleted'
            ]);
        }
    }
}
