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
        if (Auth::user()->hasRole('admin')) {
            $this->courses = course::orderBy('id', 'desc')->get();
        } else {
            $this->courses = course::where("teacher", Auth::user()->id)->get();
        }
        $this->user_list = User::orderByDesc('created_at')->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.own-all-course');
    }
}
