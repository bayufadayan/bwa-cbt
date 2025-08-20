<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CourseQuestionController extends Controller
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
    public function create(Course $course)
    {
        // dd($course);
        $students = $course->users()->orderBy('id', 'DESC')->get();
        return view('admin.questions.create', [
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
            'question' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*' => 'required|string|max:255',
            'correct_answer' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {
            $question = $course->questions()->create([
                'question' => $request->question
            ]);

            foreach ($request->answers as $index => $answerText) {
                $isCorrect = $request->correct_answer == $index;

                $question->course_answers()->create([
                    'answer' => $answerText,
                    'is_corrent' => $isCorrect,
                ]);
            }

            DB::commit();

            return redirect(route('courses.show', $course->id));
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
    public function show(CourseQuestion $courseQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseQuestion $courseQuestion)
    {
        $course = $courseQuestion->course;
        $students = $course->users()->orderBy('id', 'DESC')->get();
        return view('admin.questions.edit', [
            "course" => $course,
            "courseQuestion" => $courseQuestion,
            "students" => $students,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseQuestion $courseQuestion)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*' => 'required|string|max:255',
            'correct_answer' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {
            $courseQuestion->update([
                'question' => $request->question,
            ]);

            // Hapus data jawaban
            $courseQuestion->course_answers()->delete();
            foreach ($request->answers as $index => $answerText) {
                $isCorrect = $request->correct_answer == $index;

                $courseQuestion->course_answers()->create([
                    'answer' => $answerText,
                    'is_corrent' => $isCorrect,
                ]);
            }

            DB::commit();

            return redirect(route('courses.show', $courseQuestion->course_id));
        } catch (\Exception $e) {
            DB::rollBack();
            $err = ValidationException::withMessages([
                'system_error' => ['System Error!' . $e->getMessage()],
            ]);

            throw $err;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseQuestion $courseQuestion)
    {
        try {
            $courseQuestion->delete();
            return redirect()->route('courses.show', $courseQuestion->course_id);
        } catch (\Exception $e) {
            $err = ValidationException::withMessages([
                'system_error' => ['System Error!' . $e->getMessage()],
            ]);

            throw $err;
        }
    }
}
