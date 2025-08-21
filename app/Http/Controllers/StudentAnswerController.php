<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseAnswer;
use App\Models\CourseQuestion;
use App\Models\StudentAnswer;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentAnswerController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course, $question)
    {
        $questionDetails = CourseQuestion::where('id', $question)->first();
        $validated = $request->validate([
            'answer_id' => 'required|exists:course_answers,id',
        ]);

        DB::beginTransaction();
        try {
            $selectedAnswer = CourseAnswer::where('id', $validated['answer_id'])->first();
            if (!$selectedAnswer) {
                $err = ValidationException::withMessages([
                    'system_error' => ['Jawaban tidak tersedia!'],
                ]);

                throw $err;
            }

            $existingAnswer = StudentAnswer::where('user_id', Auth::id())
                ->where('course_question_id', $questionDetails->id)
                ->first();
            if ($existingAnswer) {
                $err = ValidationException::withMessages([
                    'system_error' => ['Anda telah menjawab pertanyaan ini sebelumnya.'],
                ]);

                throw $err;
            }

            $answerValue = $selectedAnswer->is_corrent ? 'correct' : 'wrong';

            StudentAnswer::create([
                'user_id' => Auth::id(),
                'answer' => $answerValue,
                'course_question_id' => $questionDetails->id,
            ]);

            DB::commit();

            $nextQuestion = CourseQuestion::where('course_id', $course->id)
                ->where('id', '>', $question)
                ->orderBy('id', 'ASC')
                ->first();
            // dd($course, $question, $nextQuestion);

            if ($nextQuestion) {
                return redirect(route('learning.course', ['course' => $course->id, 'question' => $nextQuestion->id]));
            } else {
                return redirect(route('learning.finished.course', $course));
            }
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
    public function show(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentAnswer $studentAnswer)
    {
        //
    }
}
