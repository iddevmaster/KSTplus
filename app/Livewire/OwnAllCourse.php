<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\course;
use App\Models\User;
use Auth;

class OwnAllCourse extends Component
{
    public $courses;
    public $user_list;

    public function mount()
    {
        $this->courses = course::where("teacher", Auth::user()->id)->orderByDesc('created_at')->get();
        $this->user_list = User::orderByDesc('created_at')->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.own-all-course');
    }
}
