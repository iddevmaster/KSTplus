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
    public $user_courses;
    public $formData = [];
    public function mount()
    {
        $users = User::orderBy('created_at', 'desc')->get(['id']);

        $query = progress::select(
            'user_id',
            'course_id',
            DB::raw('COUNT(*) as learned_lesson'),
        )->groupBy(['user_id', 'course_id'])->get();

        dd($query);
    }

    public function render()
    {
        return view('livewire.learning-report');
    }
}
