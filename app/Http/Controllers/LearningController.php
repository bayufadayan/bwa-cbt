<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\StudentAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $my_courses = $user->courses()
            ->with('category')
            ->orderBy('id', 'DESC')
            ->get();

        // Karena akan melempar 'NextQuestionId' maka akan berbeda beda, oleh karena itu perlu dimapping secara satu per satu.
        foreach ($my_courses as $course) {
            // Cek jumlah pertanyaan
            $totalQuestionsCount = $course->questions()->count();

            // Jumlah yang sudah dikerjakan
            $answeredQuestionsCount = StudentAnswer::where('user_id', $user->id)
                ->whereHas('course_question', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->distinct()
                ->count('course_question_id');

            // Setting NextQuestionId
            if ($answeredQuestionsCount < $totalQuestionsCount) {
                // Mencari nomor pertama yang belum dijawab
                $firstUnanswerdQuestion = CourseQuestion::where('course_id', $course->id)
                    ->whereNotIn('id', function ($query) use ($user) {
                        $query->select('course_question_id')
                            ->from('student_answers')
                            ->where('user_id', $user->id);
                    })
                    ->orderBy('id', 'ASC')
                    ->first();

                $course->nextQuestionId = $firstUnanswerdQuestion ? $firstUnanswerdQuestion->id : null;
            } else {
                $course->nextQuestionId = null;
            }
        }

        return view('student.courses.index', [
            'my_courses' => $my_courses
        ]);
    }

    public function learning(Course $course, $question)
    {
        $user = Auth::user();

        $isEnrolled = $user->courses()->where('course_id', $course->id)->exists();

        if (!$isEnrolled) {
            abort(404);
        }

        $currentQuestion = CourseQuestion::where('course_id', $course->id)->where('id', $question)->firstOrFail();

        return view('student.courses.learning', [
            'course' => $course,
            'question' => $currentQuestion,
        ]);
    }

    public function learning_finished(Course $course)
    {
        return "Ajib geus beres";
    }
}
