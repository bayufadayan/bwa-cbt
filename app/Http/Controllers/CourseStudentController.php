<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\StudentAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Constraint\Count;

class CourseStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $students = $course->users()->orderBy('id', 'DESC')->get();
        $totalQuestionCount = $course->questions()->count();

        foreach ($students as $student) {
            $answeredCount = StudentAnswer::where('user_id', $student->id)
                ->whereHas('course_question', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->count();

            $correctAnswerCount = StudentAnswer::where('user_id', $student->id)
                ->where('answer', 'correct')
                ->whereHas('course_question', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->count();

            if ($answeredCount === 0) {
                $student->status = 'Not Started';
            } elseif ($correctAnswerCount === $totalQuestionCount) {
                $student->status = 'Passed';
            } else {
                $student->status = 'Not Passed';
            }
        }

        return view('admin.students.index', [
            'course' => $course,
            'students' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        $students = $course->users()->orderBy('id', 'DESC')->get();
        return view('admin.students.add_student', [
            'course' => $course,
            'students' => $students,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $err = ValidationException::withMessages([
                'system_error' => ['Email student tidak tersedia!'],
            ]);

            throw $err;
        }

        $isEnrolled = $course->users()->where('user_id', $user->id)->exists();
        if ($isEnrolled) {
            $err = ValidationException::withMessages([
                'system_error' => ['Student sudah terdaftar pada course ini'],
            ]);

            throw $err;
        }

        DB::beginTransaction();

        try {

            $course->users()->attach($user->id);
            DB::commit();

            return redirect(route('course.course_students.index', $course));
        } catch (\Exception $e) {
            DB::rollBack();
            $err = ValidationException::withMessages([
                'system_error' => ['System Error!' . $e->getMessage()],
            ]);

            throw $err;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseStudent $courseStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseStudent $courseStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseStudent $courseStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseStudent $courseStudent)
    {
        //
    }
}
