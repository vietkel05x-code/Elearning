<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Course;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Danh sách tất cả câu hỏi (admin)
     */
    public function index(Request $request)
    {
        // Nếu là instructor thì dùng view instructor
        $panelUser = \App\Helpers\AdminHelper::user();
        if ($panelUser && $panelUser->role === 'instructor') {
            // Logic cho instructor - chỉ xem câu hỏi từ khóa học của mình
            $instructorCourses = \App\Models\Course::where('instructor_id', $panelUser->id)->pluck('id');
            
            $query = Question::with(['user', 'course', 'lesson', 'answers.user'])
                ->whereIn('course_id', $instructorCourses);

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by course
            if ($request->filled('course_id')) {
                $query->where('course_id', $request->course_id);
            }

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            }

            $questions = $query->latest()->paginate(20)->withQueryString();
            $courses = \App\Models\Course::where('instructor_id', $panelUser->id)->get();

            return view('admin.instructor.questions.index', compact('questions', 'courses'));
        }

        // Admin - xem tất cả
        $query = Question::with(['user', 'course', 'lesson', 'answers'])
            ->withCount('answers');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $questions = $query->latest()->paginate(20)->withQueryString();

        // Statistics
        $stats = [
            'total' => Question::count(),
            'pending' => Question::where('status', 'pending')->count(),
            'answered' => Question::where('status', 'answered')->count(),
            'closed' => Question::where('status', 'closed')->count(),
        ];

        $courses = Course::all();

        return view('admin.questions.index', compact('questions', 'stats', 'courses'));
    }

    /**
     * Xem chi tiết câu hỏi
     */
    public function show(Question $question)
    {
        // Nếu là instructor thì dùng view instructor
        $panelUser = \App\Helpers\AdminHelper::user();
        if ($panelUser && $panelUser->role === 'instructor') {
            // Kiểm tra instructor có quyền xem câu hỏi này không
            if ($question->course->instructor_id !== $panelUser->id) {
                abort(403, 'Bạn không có quyền xem câu hỏi này.');
            }
            
            $question->load(['user', 'course', 'lesson', 'answers.user']);
            
            return view('admin.instructor.questions.show', compact('question'));
        }

        // Admin
        $question->load(['user', 'course', 'lesson', 'answers.user']);
        
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Xóa câu hỏi
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Đã xóa câu hỏi!');
    }

    /**
     * Xóa câu trả lời
     */
    public function destroyAnswer(Answer $answer)
    {
        $panelUser = \App\Helpers\AdminHelper::user();
        
        // Instructor chỉ xóa được answer của mình
        if ($panelUser && $panelUser->role === 'instructor') {
            if ($answer->user_id !== $panelUser->id) {
                abort(403, 'Bạn không có quyền xóa câu trả lời này.');
            }
        }
        
        $questionId = $answer->question_id;
        $answer->delete();

        return redirect()->route('admin.questions.show', $questionId)
            ->with('success', 'Đã xóa câu trả lời!');
    }

    /**
     * Trả lời câu hỏi (instructor)
     */
    public function answer(Request $request, Question $question)
    {
        $panelUser = \App\Helpers\AdminHelper::user();
        
        // Kiểm tra quyền
        if ($panelUser && $panelUser->role === 'instructor') {
            if ($question->course->instructor_id !== $panelUser->id) {
                abort(403, 'Bạn không có quyền trả lời câu hỏi này.');
            }
        }
        
        $request->validate([
            'content' => 'required|string',
        ]);

        $answer = new Answer();
        $answer->question_id = $question->id;
        $answer->user_id = $panelUser->id;
        $answer->content = $request->content;
        $answer->save();

        // Cập nhật trạng thái câu hỏi
        if ($question->status === 'pending') {
            $question->status = 'answered';
            $question->save();
        }

        return redirect()->route('admin.questions.show', $question)
            ->with('success', 'Đã thêm câu trả lời!');
    }

    /**
     * Cập nhật câu trả lời
     */
    public function updateAnswer(Request $request, Answer $answer)
    {
        $panelUser = \App\Helpers\AdminHelper::user();
        
        // Instructor chỉ sửa được answer của mình
        if ($panelUser && $panelUser->role === 'instructor') {
            if ($answer->user_id !== $panelUser->id) {
                abort(403, 'Bạn không có quyền sửa câu trả lời này.');
            }
        }
        
        $request->validate([
            'content' => 'required|string',
        ]);

        $answer->content = $request->content;
        $answer->save();

        return redirect()->route('admin.questions.show', $answer->question_id)
            ->with('success', 'Đã cập nhật câu trả lời!');
    }
}
