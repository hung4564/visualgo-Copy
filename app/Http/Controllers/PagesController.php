<?php

namespace App\Http\Controllers;

use App\Course;
use App\Quiz;
use App\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Courses = Course::where('status_id', '1')->get();
        return view('welcome', ['records' => $Courses]);
    }
    public function showCourse($id)
    {
        $Course = Course::find($id);
        if (Auth::check()) {
            if (Auth::user()->isAdmin()||Auth::id() == $Course->Teacher->id || Auth::user()->haveCourse($id)) {
                return view('incourse', ['course' => $Course]);
            }
        }
        return view('course', ['course' => $Course]);
    }
    public function showQuiz($idCourse, $idQuiz)
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        } else {
            if (Auth::user()->isAdmin()||Auth::user()->haveCourse($idCourse)) {
                $course = Course::find($idCourse);
                if ($course->haveQuestion($idQuiz)) {
                    $quiz = Quiz::find($idQuiz);
                    return view('quiz', ['quiz' => $quiz]);
                }
            }
        }
        return redirect(route('home'));
    }
    public function showLesson($idLeson){
      $lesson = Lesson::findOrFail($idLeson);
      $link= $lesson->link;
      $detail=Storage::get($link);
      return view('lesson', ['lesson' => $lesson,'detail'=>$detail]);
    }
}
