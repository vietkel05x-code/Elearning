<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('admin_logged_in') || !$request->session()->get('admin_user_id')) {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập để truy cập khu vực quản trị.');
        }

        $panelUser = \App\Models\User::find($request->session()->get('admin_user_id'));
        if (!$panelUser || (!$panelUser->isAdmin())) {
            // Middleware này vẫn là strict admin; nếu user không phải admin thì chặn
            return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập chức năng này.');
        }

        $request->setUserResolver(function () use ($panelUser) {
            return $panelUser;
        });

        return $next($request);
    }
}
