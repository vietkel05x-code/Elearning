<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdminOrInstructor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('admin_logged_in') || !$request->session()->get('admin_user_id')) {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập để truy cập khu vực quản trị.');
        }

        $panelUser = \App\Models\User::find($request->session()->get('admin_user_id'));
        if (!$panelUser || (!$panelUser->isAdmin() && !$panelUser->isInstructor())) {
            $request->session()->forget('admin_logged_in');
            $request->session()->forget('admin_user_id');
            return redirect()->route('admin.login')->with('error', 'Phiên không hợp lệ hoặc không có quyền.');
        }

        // Inject user resolver
        $request->setUserResolver(function () use ($panelUser) {
            return $panelUser;
        });

        return $next($request);
    }
}
