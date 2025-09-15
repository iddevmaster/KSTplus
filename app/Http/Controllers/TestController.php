<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\question;
use Carbon\Carbon;
use App\Models\quiz;
use Illuminate\Support\Facades\Log;
use App\Models\Activitylog;
use App\Models\User;

class TestController extends Controller
{
    public function index(Request $request, $cid , $qzid, $ques_num) {

        Log::channel('activity')->info('User '. $request->user()->name .' start test',
        [
            'user' => $request->user(),
            'course' => $cid,
            'quiz' => $qzid
        ]);
        return view("page.quizzes.test", compact('qzid', 'cid', 'ques_num'));
    }

    public function testSummary(Request $request) {
        $scores = session('scores', 0);
        $quests = session('quests', []);
        $totalScore = session('totalScore', 0);
        $timeUsege = session('timeUsege', []);
        $quizId = session('quizId', 0);
        $cid = session('courseId', 0);
        $answers = session('answers', []);
        //  clear session -> session()->forget('scores');
        $quiz = quiz::find($quizId);

        Log::channel('activity')->info('User '. $request->user()->name .' visited test summary',
        [
            'user' => $request->user(),
            'course' => $cid,
            '$quiz' => $quiz
        ]);
        return view("page.quizzes.test_summary", compact('scores', 'quests', 'totalScore', 'timeUsege', 'quiz', 'answers', 'cid'));
    }

    public function finishTest(Request $request) {
        $testResults = session('testResults');
        // session()->flash('testResults', [
        //     'quiz'=> $this->testId,
        //     'questions'=> $this->questions,
        //     'start' => $this->startTest,
        //     'end' => $this->endTest,
        //     'submitAns' => $this->submitAns,
        // ]);
        $quests = $testResults['questions'] ?? [];
        $answers = $testResults['submitAns'] ?? [];
        $quizId = $testResults['quiz'];
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $testResults['start']);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $testResults['end']);
        $timeUsege = $startDate->diff($endDate);  // $diff->format('%d days, %h hours, %i minutes');
        $scores = 0;
        $totalScore = 0;
        foreach ($quests as $quest) {
            if ($answers[$quest->id]['status']) {
                $scores += $quest->score;
            }
            $totalScore += $quest->score;
        }
        $test = Test::create([
            'quiz'=> $testResults['quiz'],
            'tester'=> $request->user()->id,
            'start'=> $testResults['start'],
            'answers'=> json_encode($answers),
            'score' => $scores,
            'totalScore' => $totalScore,
            'end'=> $testResults['end'],
        ]);

        session([
            'scores' => $scores,
            'quests' => $quests,
            'totalScore' => $totalScore,
            'timeUsege' => $timeUsege,
            'quizId' => $quizId,
            'courseId' => $testResults['courseId'],
            'answers' => $answers,
        ]);

        Activitylog::create([
            'user' => auth()->id(),
            'module' => 'Test',
            'content' => $test->id,
            'note' => 'finish',
        ]);
        session()->forget('testResults');
        return redirect()->route('test.summary');
        // return view("page.test_summary", compact("scores", "quests", "totalScore", "timeUsege"));
    }

    public function testHistory($testid) {
        $test = Test::find($testid);
        $tester_name = User::find($test->tester)->name ?? 'N/A';
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $test->start);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $test->end);
        $timeUsege = $startDate->diff($endDate);  // $diff->format('%d days, %h hours, %i minutes');


        $scores = $test->score ?? 0;
        $totalScore = $test->totalScore ?? 0;
        $quizId = $test->quiz;
        $answers = $test->answers ?? [];
        $quests = question::whereIn('id', array_keys($answers))->get();
        //  clear session -> session()->forget('scores');
        $quiz = quiz::find($quizId);

        $cid = null;

        return view("page.quizzes.test_summary", compact('scores', 'quests', 'totalScore', 'timeUsege', 'quiz', 'answers', 'cid', 'testid', 'tester_name', 'startDate'));
    }

    public function testHistoryExport($testid) {
        $test = Test::find($testid);
        $tester_name = User::find($test->tester)->name ?? 'N/A';
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $test->start);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $test->end);
        $timeUsege = $startDate->diff($endDate);  // $diff->format('%d days, %h hours, %i minutes');


        $scores = $test->score ?? 0;
        $totalScore = $test->totalScore ?? 0;
        $quizId = $test->quiz;
        $answers = $test->answers ?? [];
        $quests = question::whereIn('id', array_keys($answers))->get();
        //  clear session -> session()->forget('scores');
        $quiz = quiz::find($quizId);

        return view("page.quizzes.test_summary_export", compact('scores', 'quests', 'totalScore', 'timeUsege', 'quiz', 'answers', 'tester_name', 'startDate'));
    }
}
