<?php

namespace App\Livewire;

use App\Models\course;
use App\Models\progress;
use App\Models\User;
use App\Models\user_has_course;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LearningReport extends Component
{
    public $users;
    public $courses;
    public $filter_user;
    public $filter_course;
    public $course_progreses;
    public $formData = [];
    public function mount()
    {
        $this->users = User::orderBy('created_at', 'desc')->get(['id', 'name']);
        $this->courses = course::orderBy('created_at', 'desc')->get(['id', 'title']);

        $this->course_progreses = progress::select(
            'user_id',
            'course_id',
            DB::raw('COUNT(*) as learned_lesson'),
            DB::raw('MAX(created_at) as last_learned_at')
        )->whereHas('user')->groupBy(['user_id', 'course_id'])->orderBy('last_learned_at', 'desc')->get();
    }

    public function filterLearning() {
        // $this->resetPage();
        $query = progress::select(
            'user_id',
            'course_id',
            DB::raw('COUNT(*) as learned_lesson'),
            DB::raw('MAX(created_at) as last_learned_at')
        );

        if ($this->filter_user) {
            $query->where('user_id', $this->filter_user);
        }

        if ($this->filter_course) {
            $query->where('course_id', $this->filter_course);
        }

        $this->course_progreses = $query->groupBy(['user_id', 'course_id'])->orderBy('last_learned_at', 'desc')->get();
    }

    // public function updated($propertyName)
    // {
    //     // เมื่อ filter ถูกเปลี่ยน ให้กลับไปหน้าแรกเสมอ
    //     $this->resetPage();
    // }

    public function render()
    {
        return view('livewire.learning-report');
    }
}
