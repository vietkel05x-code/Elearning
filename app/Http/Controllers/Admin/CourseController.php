<?php
// app/Http/Controllers/Admin/CourseController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
// use Mews\Purifier\Facades\Purifier; // nếu bạn cài purifier

class CourseController extends Controller
{
    public function create()
    {
        return view('admin.courses.form', ['course' => new Course()]);
    }

    public function index(Request $request)
    {
        $query = \App\Models\Course::query();
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $courses = $query->latest()->paginate(10)->withQueryString();
        return view('admin.courses.index', compact('courses'));
    }
 

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:courses,slug',
            'price'            => 'nullable|numeric',
            'compare_at_price' => 'nullable|numeric',
            'thumbnail_path'   => 'nullable|string',
            'status'           => 'required|string|in:draft,published,hidden,archived',
            'level'            => 'nullable|string',
            'language'         => 'nullable|string',
            'short_description' => 'nullable|string',
            'description'      => 'nullable|string',
            'description_html' => 'nullable|string',
        ]);

        // Nếu dùng purifier:
        // $data['description_html'] = Purifier::clean($data['description_html'] ?? '');

        $course = Course::create($data);
        return redirect()->route('admin.courses.edit', $course)->with('ok', 'Đã tạo khóa học');
    }

    public function edit(Course $course)
    {
        $course->load([
            'sections' => function($query) {
                $query->orderBy('position');
            },
            'sections.lessons' => function($query) {
                $query->orderBy('position');
            }
        ]);
        return view('admin.courses.form', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:courses,slug,' . $course->id,
            'price'            => 'nullable|numeric',
            'compare_at_price' => 'nullable|numeric',
            'thumbnail_path'   => 'nullable|string',
            'status'           => 'required|string|in:draft,published,hidden,archived',
            'level'            => 'nullable|string',
            'language'         => 'nullable|string',
            'short_description' => 'nullable|string',
            'description'      => 'nullable|string',
            'description_html' => 'nullable|string',
        ]);

        // $data['description_html'] = Purifier::clean($data['description_html'] ?? '');

        $course->update($data);
        return back()->with('ok', 'Đã lưu thay đổi');
    }
}
