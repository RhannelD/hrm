<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;

class EmployeeLivewire extends Component
{
    public function render()
    {
        return view('livewire.employee.employee-livewire')
            ->extends('livewire.main.main');
    }
}
