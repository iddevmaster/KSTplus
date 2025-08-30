<?php

namespace App\Livewire;

use App\Models\course;
use Livewire\Component;

class CourseReport extends Component
{
    public $courses;
    public $search;
    public function mount()
    {
        $this->courses = course::orderBy('created_at', 'desc')->get();
    }

    public function searchCourse()
    {
        if ($this->search == '' || is_null($this->search)) {
            $this->mount();
        } else {
            $query = Course::where(function ($q) {
                $q->where('code', 'LIKE', "%{$this->search}%")
                    ->orWhere('title', 'LIKE', "%{$this->search}%");
            });

            if (auth()->user()->role == 'superAdmin') {
                $this->courses = $query->orderBy('created_at', 'desc')->get();
            } else {
                $this->courses = $query->orderBy('created_at', 'desc')->get();
            }
        }
    }

    public function render()
    {
        return view('livewire.course-report', ['courses' => $this->courses]);
    }
}
