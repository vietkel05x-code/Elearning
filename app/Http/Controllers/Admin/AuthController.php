<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập admin
     */
    public function showLoginForm(Request $request)
    {
        // Kiểm tra đã đăng nhập admin chưa (dùng session key riêng)
        if ($request->session()->has('admin_logged_in') && $request->session()->get('admin_user_id')) {
            $panelUser = \App\Models\User::find($request->session()->get('admin_user_id'));
            if ($panelUser) {
                // Admin vào dashboard; instructor vào Q&A
                return ($panelUser->role === 'admin')
                    ? redirect()->route('admin.dashboard')
                    : redirect()->route('admin.questions.index');
            }
        }

        return view('admin.auth.login');
    }

    /**
     * Xử lý đăng nhập admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tìm user
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            if ($user->role === 'admin' || $user->role === 'instructor') {
                $request->session()->put('admin_logged_in', true);
                $request->session()->put('admin_user_id', $user->id);
                $request->session()->regenerate();
                // Admin vào dashboard, instructor vào Q&A
                $target = ($user->role === 'admin') ? route('admin.dashboard') : route('admin.questions.index');
                return redirect($target)->with('success', 'Đăng nhập thành công!');
            }
            return back()->withErrors([
                'email' => 'Tài khoản này không có quyền truy cập trang quản trị.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ])->onlyInput('email');
    }

    /**
     * Đăng xuất admin
     */
    public function logout(Request $request)
    {
        // Xóa session admin (không ảnh hưởng đến public login)
        $request->session()->forget('admin_logged_in');
        $request->session()->forget('admin_user_id');
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Đã đăng xuất thành công!');
    }
}

