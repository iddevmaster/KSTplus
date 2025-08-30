<?php

namespace App\Livewire;

use App\Models\branch;
use App\Models\quiz;
use App\Models\Test;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;

class TestReport extends Component
{
    use WithPagination;

    protected $testsQuery;
    public $formData = [];
    public $users;
    public $quizzes;
    public $branches;
    public function mount()
    {
        if (auth()->user()->role == 'superAdmin') {
            $this->testsQuery = Test::orderBy('created_at', 'desc');
            $this->users = User::orderBy('created_at', 'desc')->get(['id', 'name']);
            $this->branches = branch::orderBy('created_at', 'desc')->get();
            $this->quizzes = quiz::orderBy('created_at', 'desc')->get(['id', 'title']);
        } else {
            $this->testsQuery = Test::orderBy('created_at', 'desc');
            $this->users = User::where('agency', auth()->user()->agency)->orderBy('created_at', 'desc')->get(['id', 'name']);
            $this->quizzes = quiz::orderBy('created_at', 'desc')->get(['id', 'title']);
            $this->branches = branch::where('agency', auth()->user()->agency)->orderBy('created_at', 'desc')->get();
        }
    }

    public function searchTest()
    {
        $this->resetPage();

        // $filter_tests = Test::orderBy('created_at', 'desc');
        // // check if formdata has key filter_user
        // if (array_key_exists('filter_user', $this->formData)) {
        //     if ($this->formData['filter_user'] != null) {
        //         $filter_tests = $filter_tests->where('tester', $this->formData['filter_user']);
        //     }
        // }
        // // check if formdata has key filter_course
        // if (array_key_exists('filter_brn', $this->formData)) {
        //     if ($this->formData['filter_brn'] != null) {
        //         $user_list = User::where('brn', $this->formData['filter_brn'])->pluck('id')->toArray() ?? [];
        //         $filter_tests = $filter_tests->whereIn('tester', $user_list);
        //     }
        // }
        // if (array_key_exists('filter_quiz', $this->formData)) {
        //     if ($this->formData['filter_quiz'] != null) {
        //         $filter_tests = $filter_tests->where('quiz', $this->formData['filter_quiz']);
        //     }
        // }
        // if (array_key_exists('filter_sdate', $this->formData)) {
        //     if ($this->formData['filter_sdate'] != null) {
        //         $filter_tests = $filter_tests->where('created_at', '>=', $this->formData['filter_sdate']);
        //     }
        // }
        // if (array_key_exists('filter_edate', $this->formData)) {
        //     if ($this->formData['filter_edate'] != null) {
        //         $filter_tests = $filter_tests->where('created_at', '<=', $this->formData['filter_edate']);
        //     }
        // }
        // $this->testsQuery = $filter_tests;
    }

    public function updated($propertyName)
    {
        // เมื่อ filter ถูกเปลี่ยน ให้กลับไปหน้าแรกเสมอ
        $this->resetPage();
    }

    public function render()
    {
        $tests = Test::orderBy('created_at', 'desc');

        if (!empty($this->formData['filter_user'])) {
            $tests->where('tester', $this->formData['filter_user']);
        }

        if (!empty($this->formData['filter_brn'])) {
            $user_list = User::where('brn', $this->formData['filter_brn'])->pluck('id')->toArray();
            $tests->whereIn('tester', $user_list);
        }

        if (!empty($this->formData['filter_quiz'])) {
            $tests->where('quiz', $this->formData['filter_quiz']);
        }

        if (!empty($this->formData['filter_sdate'])) {
            $tests->where('created_at', '>=', $this->formData['filter_sdate']);
        }

        if (!empty($this->formData['filter_edate'])) {
            $tests->where('created_at', '<=', $this->formData['filter_edate']);
        }

        return view('livewire.test-report', [
            'tests' => $tests->paginate(20),
        ]);
    }
}
