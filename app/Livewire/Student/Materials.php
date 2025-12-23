<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Material;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.student')]
class Materials extends Component
{
    use WithPagination;

    public $search = '';
    public $subjectId = '';
    public $showFilters = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSubjectId()
    {
        $this->resetPage();
    }

    public function setSubject($id)
    {
        $this->subjectId = ($id === 'all') ? '' : $id;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->subjectId = '';
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $student = $user->student;

        $materials = Material::query()
            ->when($student, function ($query) use ($student) {
                // Filter by student's class level
                $query->where('class_level_id', $student->class_level_id);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->subjectId, function ($query) {
                $query->where('subject_id', $this->subjectId);
            })
            ->with(['subject', 'classLevel', 'tutor'])
            ->latest()
            ->paginate(12);

        $subjects = Subject::all();

        return view('livewire.student.materials', [
            'materials' => $materials,
            'subjects' => $subjects,
            'activeSubject' => $this->subjectId ?: 'all',
        ]);
    }
}
