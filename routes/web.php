<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ReqController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    Auth::logout();
    return view('auth.login');
})->name('loginpage');

// Route::get('/home', function () {
//     return view('page.home');
// })->middleware(['auth', 'verified'])->name('home');

// Route::get('/main', function () {
//     return view('page.main');
// })->middleware(['auth', 'verified'])->name('main');
// Route::get('/phpinfo', function () {
//     phpinfo();
// });

Route::middleware('auth')->group(function () {
    Route::get('/phpinfo', function () {
        phpinfo();
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/icon', [ProfileController::class, 'updateIcon'])->name('icon.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/notic/send', [HomeController::class, 'sendMessage'])->name('admin.sendMessage');
    Route::get('/notifications/mark-as-read/{id}', [HomeController::class, 'markAsRead']);
    Route::get('/notifications/success/{id}', [HomeController::class, 'noticSuccess']);
    Route::post('/add-permission-to-role', [HomeController::class, 'managePermission']);

    // page
    Route::get('/main', [HomeController::class, 'main'])->name('main');
    Route::get('/user-manual', [HomeController::class, 'userManual'])->name('user-manual');
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/course{id}/detail', [HomeController::class, 'courseDetail'])->name('course.detail');
    Route::get('/course/all', [HomeController::class, 'allCourse'])->name('course.all');
    Route::get('/users/all', [HomeController::class, 'allUsers'])->name('users.all');
    Route::get('/users/detail/{id}', [HomeController::class, 'userDetail'])->name('user.detail');
    Route::get('/request/all', [HomeController::class, 'requestAll'])->name('request.all');
    Route::get('/course/own', [HomeController::class, 'ownCourse'])->name('ownCourse');
    Route::get('/course/classroom', [HomeController::class, 'classroom'])->name('classroom');
    Route::get('/course/enrolled', [HomeController::class, 'courseEnrolled'])->name('courses-enrolled');
    Route::get('/manage', [ManageController::class, 'index'])->name('manage');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Manage
    Route::post('/manage/addAgency', [ManageController::class,'createAgency'])->name('add.agency');
    Route::post('/manage/addBranch', [ManageController::class,'createBranch'])->name('add.branch');
    Route::post('/manage/addDpm', [ManageController::class,'createDpm'])->name('add.dpm');
    Route::post('/manage/addRole', [ManageController::class,'createRole']);
    Route::post('/manage/editRole', [ManageController::class,'updateRole']);
    Route::post('/manage/addPerm', [ManageController::class,'createPerm']);
    Route::post('/manage/delete', [ManageController::class,'deleteData']);
    Route::post('/manage/update', [ManageController::class,'update']);
    Route::get('/restore/{resType}/{resId}', [ManageController::class,'restore']);

    //User
    Route::post('/user/register', [UserController::class,'create'])->name('user.register');
    Route::post('/user/delete', [UserController::class,'destroy']);
    Route::post('/user/update', [UserController::class,'update']);
    Route::post('/user/renew', [UserController::class,'renew']);
    Route::post('/user/add/course', [UserController::class,'addCourse']);
    Route::post('/user/add/group', [UserController::class,'addGroup']);
    Route::post('/user/remove/course', [UserController::class,'removeCourse']);
    Route::get('/progress/add/', [UserController::class,'addProgress']);

    // course
    Route::post('/course/add', [CourseController::class,'store']);
    Route::post('/course/update', [CourseController::class,'update']);
    Route::post('/course/delete', [CourseController::class,'delete']);
    Route::get('/course{cid}/enroll', [CourseController::class,'enroll'])->name('enroll');
    Route::get('/course/enroll/list', [CourseController::class,'enrollList'])->name('enroll-list');
    Route::get('/search-courses', [CourseController::class, 'search'])->name('courses.search');
    Route::get('/search-mycourses', [CourseController::class, 'searchMy'])->name('courses.searchmy');
    Route::post('/course/lesson/add', [CourseController::class,'addLesson'])->name('lesson.add');
    Route::post('/course/lesson/update', [CourseController::class,'updateLesson'])->name('lesson.update');
    Route::post('/lesson/sublesson/add', [CourseController::class,'subLessAdd']);
    Route::post('/lesson/sublesson/delete', [CourseController::class,'subLessDel']);
    Route::get('/courses/search/enrolled', [CourseController::class, 'searchEn'])->name('courses.search.enrolled');
    Route::get('/courses/search/dpm', [CourseController::class, 'searchDpm'])->name('courses.search.dpm');
    Route::get('/courses/search/all', [CourseController::class, 'searchAll'])->name('courses.search.all');
    Route::get('/course/group/delete/{gid}', [CourseController::class, 'delGroup']);
    Route::post('/course/group/add/', [CourseController::class, 'addGroup'])->name('courses.add.group');

    // quiz
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');
    Route::post('/quiz/add', [QuizController::class,'store'])->name('quiz.store');
    Route::post('/quiz/update/{id}', [QuizController::class,'update'])->name('quiz.update');
    Route::get('/quiz/detail/{id}', [QuizController::class,'quizDetail'])->name('quiz.detail');
    Route::get('/quiz/question/add/{id}', [QuizController::class, 'addQuestion'])->name('quiz.quest.add');
    Route::get('/quiz{qid}/question{id}/edit', [QuizController::class, 'editQuestion'])->name('quiz.quest.edit');
    Route::post('/quiz/question/store/{id}', [QuizController::class, 'storeQuestion'])->name('quiz.quest.store');
    Route::post('/quiz/question/update/{id}', [QuizController::class, 'updateQuestion'])->name('quiz.quest.update');
    Route::get('/quiz/question/delete/{id}', [QuizController::class, 'delQuestion'])->name('quiz.quest.del');
    Route::get('/quiz/delete/{id}', [QuizController::class, 'destroy'])->name('quiz.del');
    Route::get('/quiz/copy/{id}', [QuizController::class, 'copyQuiz'])->name('quiz.copy');
    Route::get('/quiz/record/{qid}', [QuizController::class, 'testRecord'])->name('quiz.record');

    // request
    Route::get('/request/add', [ReqController::class, 'addReq'])->name('add-req');
    Route::post('/request/store', [ReqController::class, 'storeReq'])->name('store-req');
    Route::get('/notifications/mark-as-finish/{id}', [ReqController::class, 'markAsFinish']);
    Route::get('/notifications/mark-as-fail/{id}', [ReqController::class, 'markAsFail']);
    Route::get('/notifications/mark-as-accept', [ReqController::class, 'markAsAccept']);


    // Take Exam
    Route::get('/test/start/{cid}/{qzid}/{ques_num}', [TestController::class, 'index'])->name('test.start');
    Route::get('/test/summary', [TestController::class, 'testSummary'])->name('test.summary');
    Route::get('/test/finish', [TestController::class, 'finishTest'])->name('test.finish');
    Route::get('/test/history/{testid}', [TestController::class, 'testHistory'])->name('test.history.show');
    Route::get('/test/history/export/{testid}', [TestController::class, 'testHistoryExport'])->name('test.history.export');

    // Export file
    Route::get('/export/{type}', [HomeController::class, 'previewPDF'])->name('export.pdf');

    // Report
    Route::get('/report/course', [ReportController::class, 'courseReport'])->name('course.report');
    Route::get('/report/test', [ReportController::class, 'testReport'])->name('test.report');
    Route::get('/report/learning', [ReportController::class, 'learningReport'])->name('learning.report');
    Route::get('/export2pdf/course', [ReportController::class, 'courseExport'])->name('course.export');
    Route::get('/export2pdf/test', [ReportController::class, 'testExport'])->name('test.export');


    Route::get('/language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    })->name('switch-language');


});

require __DIR__.'/auth.php';
