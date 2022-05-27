<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->is_admin == 1) {
                return $next($request);
            } else if (Auth::user()->is_admin == 0) {
                return redirect()->route('welcome');
            }
            return redirect()->route('admin.auth.login')->with('error', 'Tài khoản không đúng');
        }
        return redirect()->route('admin.auth.login')->with('error', 'Vui lòng đăng nhập');
    }
}
