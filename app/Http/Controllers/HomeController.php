<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ Lấy 9 danh mục hiển thị ở phần đầu
        $categories = Category::take(9)->get();

        // ✅ Lấy 3 khóa học nổi bật (nếu bạn muốn hiển thị phần "Hot courses" hoặc "Featured")
        $featuredCourses = Course::where('status', 'published')
            ->orderBy('rating', 'desc')
            ->take(3)
            ->get();

        // ✅ Lấy 5 danh mục nổi bật để hiển thị phần "Skills to transform your career and life"
        $topCategories = Category::take(9)->get();

        // ✅ Với mỗi danh mục, lấy 4 khóa học đầu tiên
        $coursesByCategory = [];
        foreach ($topCategories as $category) {
            $coursesByCategory[$category->id] = Course::where('category_id', $category->id)
                ->where('status', 'published')
                ->take(4)
                ->get();
        }

        // ✅ Trả dữ liệu về view
        return view('home', compact('categories', 'featuredCourses', 'topCategories', 'coursesByCategory'));
    }
}
