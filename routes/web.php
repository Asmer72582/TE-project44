<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
    return redirect("login");
});

Route::get('/test', function() {
    return view("student.landingpage");
});


Route::get('/chat', 'App\Http\Controllers\PusherController@index');
Route::post('/chat/broadcast', 'App\Http\Controllers\PusherController@broadcast');
Route::post('/chat/receive', 'App\Http\Controllers\PusherController@receive');


Route::get('/dashboard', function () {

    if (Auth::user()->user_type == "student") {
        return redirect("/dashboard/student");
    } else if (Auth::user()->user_type == "superadmin") {
        return redirect("/dashboard/superadmin");
    } else {
        return redirect("/dashboard/instructor");
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Student
    Route::middleware('role:student')->group(function () {
        Route::get('/dashboard/student', function () {
            return view("student.dashboard");
        })->name("student.dashboard");

        Route::get('/dashboard/student/participants', function () {
            return view("student.participants");
        })->name("student.participants");

        Route::get('/dashboard/student/proposals', function () {
            return view("student.proposals");
        })->name("student.proposals");

        Route::get('/dashboard/student/tasks', function () {
            return view("student.tasks");
        })->name("student.tasks");

        Route::get('/dashboard/student/notifications', function () {
            return view("student.notifications");
        })->name("student.notifications");

        Route::get('/dashboard/student/calender', function () {
            return view("student.calender");
        })->name("student.calender");

        Route::get('/dashboard/student/repositories', function () {
            return view("student.repositories");
        })->name("student.repositories");
    });


    // Instructor
    Route::middleware("role:instructor")->group(function () {

        Route::get('/dashboard/instructor', function () {
            return view("instructor.dashboard");
        })->name("instructor.dashboard");

        Route::get('/dashboard/instructor/participants', function () {
            return view("instructor.participants");
        })->name("instructor.participants");

        Route::get('/dashboard/instructor/tasks', function () {
            return view("instructor.tasks");
        })->name("instructor.tasks");

        Route::get('/dashboard/instructor/proposals', function () {
            return view("instructor.proposals");
        })->name("instructor.proposals");

        Route::get('/dashboard/instructor/notifications', function () {
            return view("instructor.notifications");
        })->name("instructor.notifications");

        Route::get('/dashboard/instructor/repositories', function () {
            return view("instructor.repositories");
        })->name("instructor.repositories");

        Route::get('/dashboard/instructor/repositories/folder/{folder_id}', function ($folder_id) {
            return view("instructor.repositories_folder", ["folder_id" => $folder_id]);
        })->name("instructor.open.folder");
    });

    Route::middleware("role:superadmin")->group(function () {

        Route::get('/dashboard/superadmin', function () {
            return view("superadmin.dashboard");
        })->name("superadmin.dashboard");

        Route::get('/dashboard/superadmin/groups', function () {
            return view("superadmin.participants", ["group_no" => null]);
        })->name("superadmin.participants");

        Route::get('/dashboard/superadmin/groups/{group_no}', function ($group_no) {
            return view("superadmin.participants", ["group_no" => $group_no]);
        })->name("superadmin.participant");

        Route::get('/dashboard/superadmin/tasks', function () {
            return view("superadmin.tasks");
        })->name("superadmin.tasks");

        Route::get('/dashboard/superadmin/notifications', function () {
            return view("superadmin.notifications");
        })->name("superadmin.notifications");

        Route::get('/dashboard/superadmin/repositories', function () {
            return view("superadmin.dashboard");
        })->name("superadmin.repositories");

        Route::get('/dashboard/superadmin/progress/{group_no}', function ($group_no) {
            return view("superadmin.progress", ['group_no' => $group_no]);
        })->name("superadmin.progress");

        // Route::get('/dashboard/superadmin', function () {
        //     return view("superadmin.dashboard");
        // })->name("superadmin.participants");

        // Route::get('/dashboard/superadmin', function () {
        //     return view("superadmin.dashboard");
        // })->name("superadmin.participants");

        // Route::get('/dashboard/superadmin', function () {
        //     return view("superadmin.dashboard");
        // })->name("superadmin.dashboard");

    });




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
