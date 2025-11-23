<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Dashboard - danh sách câu hỏi của instructor
     */
    public function index(Request $request)
    {
        $query = Question::with(['user', 'course', 'lesson', 'answers'])
            ->withCount('answers');

        // Nếu không phải admin, chỉ xem câu hỏi của khóa học mình dạy
        if (!Auth::user()->isAdmin()) {
            $query->whereHas('course', function($q) {
                $q->where('instructor_id', Auth::id());
            });
        }

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

        // Get courses for filter
        $coursesQuery = Course::query();
        if (!Auth::user()->isAdmin()) {
            $coursesQuery->where('instructor_id', Auth::id());
        }
        $courses = $coursesQuery->get();

        return view('instructor.questions.index', compact('questions', 'courses'));
    }

    /**
     * Xem chi tiết câu hỏi và trả lời
     */
    public function show(Question $question)
    {
        // Kiểm tra quyền truy cập
        if (!Auth::user()->isAdmin() && $question->course->instructor_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem câu hỏi này.');
        }

        $question->load(['user', 'course', 'lesson', 'answers.user']);
        $question->incrementViews();

        return view('instructor.questions.show', compact('question'));
    }

    /**
     * Trả lời câu hỏi
     */
    public function answer(Request $request, Question $question)
    {
        // Kiểm tra quyền truy cập
        if (!Auth::user()->isAdmin() && $question->course->instructor_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền trả lời câu hỏi này.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $answer = Answer::create([
            'question_id' => $question->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        // Cập nhật status của question
        if ($question->status === 'pending') {
            $question->update(['status' => 'answered']);
        }

        return redirect()->route('instructor.questions.show', $question)
            ->with('success', 'Đã trả lời câu hỏi thành công!');
    }

    /**
     * Sửa câu trả lời
     */
    public function updateAnswer(Request $request, Answer $answer)
    {
        // Kiểm tra quyền sở hữu
        if ($answer->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa câu trả lời này.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $answer->update(['content' => $validated['content']]);

        return redirect()->route('instructor.questions.show', $answer->question)
            ->with('success', 'Đã cập nhật câu trả lời!');
    }

    /**
     * Xóa câu trả lời
     */
    public function destroyAnswer(Answer $answer)
    {
        // Kiểm tra quyền sở hữu
        if ($answer->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Bạn không có quyền xóa câu trả lời này.');
        }

        $questionId = $answer->question_id;
        $answer->delete();

        return redirect()->route('instructor.questions.show', $questionId)
            ->with('success', 'Đã xóa câu trả lời!');
    }
}
