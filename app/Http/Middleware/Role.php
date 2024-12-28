<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, ...$roles)
  {

    if (!Auth::check()) {
      return redirect()->route('/auth/login-basic');
    }
    // dd(Auth::user()->role);
    if (!in_array(Auth::user()->role, $roles)) {
      return redirect()->route('not-found')->with('error', 'Kamu tidak memiliki akses ke halaman ini!');
    }

    return $next($request);
  }
}
