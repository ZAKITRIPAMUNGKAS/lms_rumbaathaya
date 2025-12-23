<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.student')]
class Quiz extends Component
{
    public function render()
    {
        return view('livewire.student.quiz');
    }
}
