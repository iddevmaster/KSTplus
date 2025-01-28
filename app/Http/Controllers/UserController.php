<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\course;
use App\Models\progress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
Use Alert;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Activitylog;
use App\Models\course_group;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'agn' => ['required', 'string', 'max:255'],
            'brn' => ['required', 'string', 'max:255'],
            'dpm' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'The name field is mandatory!',
            'username.required' => 'The username field is mandatory!',
            'agn.required' => 'The agency field is mandatory!',
            'brn.required' => 'The branch field is mandatory!',
            'dpm.required' => 'The department field is mandatory!',
            'role.required' => 'The role field is mandatory!',

        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => $request->password,
                'agency' => $request->agn,
                'brn' => $request->brn,
                'dpm' => $request->dpm,
                'role' => $request->role,

                'courses' => $request->courses ?? [],
                'startlt' => ($request->role == 'new' ? date('Y-m-d') : null),
            ]);
            foreach (Role::all() as $role) {
                if ($user->hasRole($role->name)) {
                    $user->removeRole($role->name);
                }
            }
            $user->assignRole($request->role);

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'User',
                'content' => $user->id,
                'note' => 'create',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' create new User',
            [
                'user' => $request->user(),
                'user_create' => $user,
            ]);
            alert()->success('Success','User has been created!');
        } catch (\Throwable $th) {
            alert()->error('Some thing worng!', $th->getMessage());
        }
        return Redirect::route('users.all');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'agn' => ['required', 'string', 'max:255'],
                'brn' => ['required', 'string', 'max:255'],
                'dpm' => ['required', 'string', 'max:255'],
                'role' => ['required', 'string', 'max:255'],
            ], [
                'name.required' => 'The name field is mandatory!',
                'username.required' => 'The username field is mandatory!',
                'agn.required' => 'The agency field is mandatory!',
                'brn.required' => 'The branch field is mandatory!',
                'dpm.required' => 'The department field is mandatory!',
                'role.required' => 'The role field is mandatory!',
            ]);

            $user = User::find($request->uid);
            $user->name = $request->name;
            $user->username = $request->username;
            if (strlen($request->password) >= 8) {
                $user->password = $request->password;
            }
            $user->agency = $request->agn;
            $user->brn = $request->brn;
            $user->dpm = $request->dpm;
            $user->role = $request->role;
            $user->startlt = ($request->role == 'new' ? date('Y-m-d') : null);
            foreach (Role::all() as $role) {
                if ($user->hasRole($role->name)) {
                    $user->removeRole($role->name);
                }
            }
            $user->assignRole($request->role);
            $user->save();

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'User',
                'content' => $user->id,
                'note' => 'update',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' update user',
            [
                'user' => $request->user(),
                'user_update' => $user,
            ]);
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $user = User::find( $request->delid )->delete();

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'User',
                'content' => $user->id,
                'note' => 'delete',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' delete user',
            [
                'user' => $request->user(),
                'user_destroy' => $user,
            ]);
            return response()->json(['success' => $request->all() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function renew(Request $request)
    {
        try {
            $user = User::find( $request->uid );
            $user->update(['startlt'=> $request->date]);

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'User',
                'content' => $user->id,
                'note' => 'renew',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' renew user',
            [
                'user' => $request->user(),
                'user_renew' => $user,
            ]);
            return response()->json(['success' => $request->all() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function addCourse(Request $request) {
        try {
            $user = User::find( $request->uid );
            $courses = course::whereIn('id', $request->courses )->get();
            $courseContainer = [];
            $stdContainer = [];
            if (is_array($user->courses)) {
                $course_list = $user->courses ?? [];
            } else {
                $course_list = json_decode($user->courses ?? '', true);
            }
            $oCourses = $course_list ?? [];
            if (count($oCourses) > 0) {
                $courseContainer = array_unique(array_merge($oCourses, $request->courses));
            } else {
                $courseContainer = $request->courses;
            }

            foreach ($courses as $course) {
                $oStd = $course->studens;
                if (count($oStd ?? []) > 0) {
                    $stdContainer = $oStd;
                }
                if (!($stdContainer[$user->id] ?? false)) {
                    $stdContainer[$user->id] = date('Y-m-d');
                }
                $course->studens = $stdContainer;
                $course->save();
            }
            $user->courses = json_encode($courseContainer);
            $user->save();

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'User',
                'content' => json_encode($request->courses),
                'note' => 'add course',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' add couser to user',
            [
                'user' => $request->user(),
                'user_added' => $user,
                'course_add' => $courses,
            ]);
            return response()->json(['success' => $stdContainer ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function removeCourse(Request $request) {
        try {
            $course = course::find($request->cid);
            $user = User::find($request->uid);

            if (!$course || !$user) {
                return response()->json(['error' => 'Course or User not found.'], 404);
            }

            // remove student from course
            $studentsC = $course->studens;
            if (array_key_exists($request->uid, $studentsC)) {
                unset($studentsC[$request->uid]);
            }

            // remove course from user
            $userCourse = [];
            if (is_array($user->courses)) {
                $course_list = $user->courses ?? [];
            } else {
                $course_list = json_decode($user->courses ?? '', true);
            }
            foreach ($course_list as $courseId) {
                if ($request->cid != $courseId) {
                    $userCourse[] = $courseId;
                }
            }

            // save to database
            $course->studens = $studentsC;
            $user->courses = json_encode($userCourse);
            $user->save();
            $course->save();

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'User',
                'content' => $course->id,
                'note' => 'remove course',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' remove course from user',
            [
                'user' => $request->user(),
                'user_remove_from' => $user,
            ]);
            return response()->json(['success' => $request->all() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function addProgress(Request $request) {
        try {
            $cid = $request->query('cid');
            $lessid = $request->query('lessid');
            $userId = $request->user()->id;

            // Check if the progress already exists
            $progressExists = progress::where('course_id', $cid)
                                      ->where('lesson_id', $lessid)
                                      ->where('user_id', $userId)
                                      ->exists();

            if (!$progressExists) {
                // Only create a new record if it does not exist
                progress::create(['course_id' => $cid, 'lesson_id' => $lessid, 'user_id' => $userId]);
                return response()->json(['message' => 'Progress added']);
            } else {
                // Return a message indicating that the progress already exists
                return response()->json(['message' => 'Progress already exists']); // 409 Conflict
            }

        } catch (\Throwable $th) {
            // Handle exceptions and return an error message
            return response()->json(['message' => $th->getMessage()], 500); // 500 Internal Server Error
        }
    }


    public function addGroup(Request $request) {
        try {
            $user = User::find( $request->uid );
            $group = course_group::whereIn('id', $request->groups ?? [])->first();
            $courses = course::whereIn('id', $group->courses ?? [] )->get();
            $courseContainer = [];
            $stdContainer = [];
            if (is_array($user->courses)) {
                $course_list = $user->courses;
            } else {
                $course_list = json_decode($user->courses ?? '', true);
            }
            $oCourses = $course_list ?? [];
            if (count($oCourses) > 0) {
                $courseContainer = array_unique(array_merge($oCourses, $group->courses ?? []));
            } else {
                $courseContainer = $group->courses ?? [];
            }

            foreach ($courses as $course) {
                $oStd = $course->studens;
                if (count($oStd ?? []) > 0) {
                    $stdContainer = $oStd;
                }
                if (!($stdContainer[$user->id] ?? false)) {
                    $stdContainer[$user->id] = date('Y-m-d');
                }
                $course->studens = $stdContainer;
                $course->save();
            }
            $user->courses = json_encode($courseContainer);
            $user->save();

            Activitylog::create([
                'user' => auth()->id(),
                'module' => 'User',
                'content' => json_encode($request->courses),
                'note' => 'add course',
            ]);
            Log::channel('activity')->info('User '. $request->user()->name .' add couser to user',
            [
                'user' => $request->user(),
                'user_added' => $user,
                'course_add' => $courses,
            ]);
            return response()->json(['success' => $courseContainer]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

}
