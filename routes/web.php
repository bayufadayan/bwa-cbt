<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseQuestionController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAnswerController;
use App\Models\CourseQuestion;
use App\Models\StudentAnswer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->group(function () {
        Route::middleware('role:teacher')->group(function () {
            Route::resource('courses', CourseController::class);
            Route::get('/course/question/create/{course}', [CourseQuestionController::class, 'create'])
                ->name('course.create.question');
            Route::post('/course/question/save/{course}', [CourseQuestionController::class, 'store'])
                ->name('course.create.question.store');
            Route::resource('course_questions', CourseQuestionController::class);

            Route::get('/course/students/show/{course}', [CourseStudentController::class, 'index'])
                ->name('course.course_students.index');
            Route::get('/course/student/create/{course}', [CourseStudentController::class, 'create'])
                ->name('course.course_students.create');
            Route::post('/course/student/save/{course}', [CourseStudentController::class, 'store'])
                ->name('course.course_students.store');
        });

        Route::middleware(['role:student'])->group(function () {
            Route::get('/learning/finished/{course}', [LearningController::class, 'learning_finished'])
                ->name('learning.finished.course');
            Route::get('/learning/raport/{course}', [LearningController::class, 'learning_raport'])
                ->name('learning.raport.course');

            // Menampilkan beberapa kelas yang diberikan guru
            Route::get('/learning', [LearningController::class, 'index'])
                ->name('learning.index');
            Route::get('/learning/{course}/{question}', [LearningController::class, 'learning'])
                ->name('learning.course');
            Route::post('/learning/{course}/{question}', [StudentAnswerController::class, 'store'])
                ->name('learning.course.answer.store');
        });
    });
});

require __DIR__ . '/auth.php';
