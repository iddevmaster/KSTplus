<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\course_group;
use App\Models\course;

class OwnGroupCourse extends Component
{
    public $courses = [];
    public $all_courses = [];
    public $group;
    public $gName;
    public $gCourses = [];
    public $editMode = false;

    public function mount($gid)
    {
        $this->group = course_group::find($gid);
        $this->courses = course::whereIn("id", $this->group->courses ?? [])->get();
        $this->all_courses = course::where("teacher", auth()->id())->get();
        $this->gCourses = $this->courses->pluck('id')->toArray();
        $this->gName =  $this->group->name;
    }

    public function updateGroup()
    {
        try {
            $this->group->update([
                'name' => $this->gName,
                'courses' => json_encode($this->gCourses),
            ]);
            $this->group->save();
        } catch (\Throwable $th) {
            $this->dispatch('error');
        }

        $this->switchToGroupMode();
    }

    public function switchToEditMode()
    {
        $this->editMode = true;
    }
    public function switchToGroupMode()
    {
        $this->editMode = false;
    }

    public function render()
    {
        if ($this->editMode) {
            return view('livewire.edit-group-course'); // Render the edit course component
        } else {
            return view('livewire.own-group-course'); // Render the group course component
        }
    }
}
