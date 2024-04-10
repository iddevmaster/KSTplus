<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\question;
use App\Models\quiz;
use App\Models\Test;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Activitylog;

class QuizController extends Controller
{
    public function index(Request $request) {
        if (auth()->user()->hasRole('admin')) {
            $quizs = quiz::orderBy('id', 'desc')->get();
        } else {
            $quizs = quiz::where('create_by', auth()->user()->id)->orderBy('id', 'desc')->get();
        }

        Log::channel('activity')->info('User '. $request->user()->name .' visited allquizzes',
        [
            'user' => $request->user(),
        ]);
        if ($request->user()->hasPermissionTo('quiz')) {
            return view("page.quizzes.allquizzes", compact("quizs"));
        } else {
            return redirect('/');
        }
    }

    public function testRecord(Request $request, $qid) {
        $quiz = quiz::find($qid);
        $testes = Test::where('quiz', $qid)->orderBy('id', 'desc')->get();

        Log::channel('activity')->info('User '. $request->user()->name .' visited test record',
        [
            'user' => $request->user(),
            'quiz' => $quiz
        ]);
        return view("page.quizzes.test_record", compact("qid", "testes", "quiz"));
    }

    public function addQuestion(Request $request, $id) {
        $quiz = quiz::find($id);

        Log::channel('activity')->info('User '. $request->user()->name .' visited add question',
        [
            'user' => $request->user(),
            'quiz' => $quiz,
        ]);
        return view("page.quizzes.add_question", compact("id", "quiz"));
    }

    public function editQuestion(Request $request, $qid, $id) {
        $quiz = quiz::find($qid);
        $quest = Question::find($id);

        Log::channel('activity')->info('User '. $request->user()->name .' visited edit question',
        [
            'user' => $request->user(),
            'question' => $quest,
        ]);
        return view("page.quizzes.quest_edit", compact("id","quest","quiz"));
    }

    public function quizDetail(Request $request, $id) {
        $questions = question::where("quiz", $id)->get();
        $quiz = quiz::find($id);

        Log::channel('activity')->info('User '. $request->user()->name .' visited quiz detail',
        [
            'user' => $request->user(),
            'quiz' => $quiz,
        ]);
        return view("page.quizzes.quiz_detail", compact("id", "questions", 'quiz'));
    }

    public function store(Request $request) {
        $request->validate([
            'quizname' => ['required', 'string', 'max:1000'],
            'timelimit' => ['required', 'max:10'],
            'passScore' => ['required', 'max:10'],
        ]);
        try {
            $quiz = quiz::create([
                'title'=> $request->quizname,
                'time_limit'=> $request->timelimit,
                'pass_score'=> $request->passScore,
                'shuffle_quest'=> $request->shuffq ?? false,
                'create_by'=> $request->user()->id,
                'showAns' => $request->showAns ?? false,
            ]);

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'Quiz',
                'content' => $quiz->id,
                'note' => 'store',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' store quiz',
            [
                'user' => $request->user(),
                'quiz' => $quiz,
            ]);
            return redirect()->back()->with('success','Quiz has been saved.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'quizname' => ['required', 'string', 'max:1000'],
            'timelimit' => ['required', 'max:10'],
            'passScore' => ['required', 'max:10'],
        ]);
        try {
            $quiz = quiz::find($id);
            $quiz->update([
                'title'=> $request->quizname,
                'time_limit'=> $request->timelimit,
                'pass_score'=> $request->passScore,
                'shuffle_quest'=> $request->shuffq ?? false,
                'create_by'=> $request->user()->id,
                'showAns' => $request->showAns ?? false,
            ]);

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'Quiz',
                'content' => $quiz->id,
                'note' => 'update',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' update quiz',
            [
                'user' => $request->user(),
                'quiz' => $quiz,
            ]);
            return redirect()->back()->with('success','Quiz has been updated.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function destroy(Request $request, $id) {
        try {
            $quiz = quiz::find($id);

            if ($quiz) {
                $quiz->delete();
            }

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'Quiz',
                'content' => $quiz->id,
                'note' => 'delete',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' delete quiz',
            [
                'user' => $request->user(),
                'quiz' => $quiz,
            ]);
            return response()->json(['success' => 'Question has been deleted.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function copyQuiz(Request $request, $id) {
        $quiz = quiz::find($id);
        $questions = question::where('quiz', $id)->get();
        if ($quiz) {
            $copyQuiz = $quiz->replicate([
                'for_courses',
                'deleted_at'
            ])->fill([
                'title' => $quiz->title . '-copy'
            ]);
            $copyQuiz->save();

            if ($questions) {
                foreach ($questions as $index => $question) {
                    $copyQues = $question->replicate()->fill([
                        'quiz' => $copyQuiz->id
                    ]);
                    $copyQues->save();
                }
            }
        }

        Activitylog::create([
            'user' => auth()->id(),
            'module' => 'Quiz',
            'content' => $quiz->id,
            'note' => 'copy',
        ]);
        Log::channel('activity')->info('User '. $request->user()->name .' copy quiz',
        [
            'user' => $request->user(),
            'quiz' => $quiz,
        ]);
        return response()->json(['success' => $copyQuiz]);
    }

    public function storeQuestion(Request $request, $id) {
        try {
            $question = new question;
            $question->quiz = $id;
            $question->title = $request->title;
            $question->score = $request->score;
            $question->shuffle_ch = $request->shuffle ?? false;

            $choices = [];

            if ($request->ansType) // type 1 = choice , type 0 = text
            {
                $choicesNum = $request->choices ?? 0;
                for ($i=1; $i <= $choicesNum; $i++) {
                    $choices[] = [
                        'id'=> $i,
                        'type'=> 'choice',
                        'text'=> $request->input('choice'.$i),
                        'answer'=> $request->input('answer'.$i, 0),
                    ];
                }
            } else {
                $choices[] = [
                    'id'=> 't',
                    'type'=> 'text',
                    'text'=> '',
                    'answer'=> $request->writing,
                ];
            }

            $question->answer = json_encode( $choices );
            $question->type = $request->ansType;  // type 1 = choice , type 0 = text
            $question->save();

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'Question',
                'content' => $question->id,
                'note' => 'store',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' store question',
            [
                'user' => $request->user(),
                'question' => $question,
            ]);
            return redirect()->route('quiz.detail', ['id' => $id])->with('success','Question has been saved.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function updateQuestion(Request $request, $id) {
        try {
            $question = Question::find($id);
            $question->title = $request->title;
            $question->score = $request->score;
            $question->shuffle_ch = $request->shuffle ?? false;

            $choices = [];

            if ($request->ansType) // type 1 = choice , type 0 = text
            {
                $choicesNum = $request->choices ?? 0;
                for ($i=1; $i <= $choicesNum; $i++) {
                    $choices[] = [
                        'id'=> $i,
                        'type'=> 'choice',
                        'text'=> $request->input('choice'.$i),
                        'answer'=> $request->input('answer'.$i, 0),
                    ];
                }
            } else {
                $choices[] = [
                    'id'=> 't',
                    'type'=> 'text',
                    'text'=> '',
                    'answer'=> $request->writing,
                ];
            }

            $question->answer = json_encode( $choices );
            $question->type = $request->ansType;  // type 1 = choice , type 0 = text
            $question->save();

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'Question',
                'content' => $question->id,
                'note' => 'update',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' update question',
            [
                'user' => $request->user(),
                'question' => $question,
            ]);
            return redirect()->route('quiz.detail', ['id' => $question->quiz])->with('success','Question has been updated.');

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function delQuestion(Request $request, $id) {
        try {
            $question = question::find($id)->delete();

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'Question',
                'content' => $question->id,
                'note' => 'delete',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' delete question',
            [
                'user' => $request->user(),
                'question' => $question,
            ]);
            return response()->json(['success' => 'Question has been deleted.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
