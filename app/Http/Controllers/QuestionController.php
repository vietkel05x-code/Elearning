<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Danh sách câu hỏi của một khóa học
     */
    public function index(Course $course)
    {
        // Kiểm tra enrollment
        if (!$course->isEnrolledBy(Auth::id())) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Bạn chưa đăng ký khóa học này!');
        }

        $questions = Question::where('course_id', $course->id)
            ->with(['user', 'lesson', 'answers'])
            ->withCount('answers')
            ->latest()
            ->paginate(20);

        return view('questions.index', compact('course', 'questions'));
    }

    /**
     * Form tạo câu hỏi mới
     */
    public function create(Course $course, Request $request)
    {
        // Kiểm tra enrollment
        if (!$course->isEnrolledBy(Auth::id())) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Bạn chưa đăng ký khóa học này!');
        }

        // Lấy lesson_id nếu có (từ query string)
        $lessonId = $request->get('lesson_id');
        $lesson = null;
        
        if ($lessonId) {
            $lesson = Lesson::find($lessonId);
        }

        $lessons = $course->sections()->with('lessons')->get()
            ->pluck('lessons')->flatten();

        return view('questions.create', compact('course', 'lessons', 'lesson'));
    }

    /**
     * Lưu câu hỏi mới
     */
    public function store(Request $request, Course $course)
    {
        // Kiểm tra enrollment
        if (!$course->isEnrolledBy(Auth::id())) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Bạn chưa đăng ký khóa học này!');
        }

        $validated = $request->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $question = Question::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'lesson_id' => $validated['lesson_id'] ?? null,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => 'pending',
        ]);

        return redirect()->route('questions.show', [$course, $question])
            ->with('success', 'Câu hỏi đã được gửi thành công!');
    }

    /**
     * Xem chi tiết câu hỏi và các câu trả lời
     */
    public function show(Course $course, Question $question)
    {
        // Kiểm tra enrollment
        if (!$course->isEnrolledBy(Auth::id())) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Bạn chưa đăng ký khóa học này!');
        }

        // Kiểm tra question thuộc course
        if ($question->course_id !== $course->id) {
            abort(404);
        }

        // Increment views
        $question->incrementViews();

        $question->load(['user', 'lesson', 'answers.user']);

        return view('questions.show', compact('course', 'question'));
    }

    /**
     * Đánh dấu câu hỏi đã được giải quyết
     */
    public function markResolved(Course $course, Question $question)
    {
        // Kiểm tra quyền sở hữu
        if ($question->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }

        $question->markAsResolved();

        return redirect()->route('questions.show', [$course, $question])
            ->with('success', 'Đã đánh dấu câu hỏi là đã giải quyết!');
    }

    /**
     * Chọn câu trả lời tốt nhất
     */
    public function selectBestAnswer(Course $course, Question $question, Answer $answer)
    {
        // Kiểm tra quyền sở hữu câu hỏi
        if ($question->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }

        // Kiểm tra answer thuộc question
        if ($answer->question_id !== $question->id) {
            abort(404);
        }

        $answer->markAsBest();

        return redirect()->route('questions.show', [$course, $question])
            ->with('success', 'Đã chọn câu trả lời tốt nhất!');
    }

    /**
     * Xóa câu hỏi (chỉ người tạo)
     */
    public function destroy(Course $course, Question $question)
    {
        // Kiểm tra quyền sở hữu
        if ($question->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }

        $question->delete();

        return redirect()->route('questions.index', $course)
            ->with('success', 'Đã xóa câu hỏi!');
    }
}
