<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Guest
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next)
  {
    if (Auth::check()) {
      if (Auth::user()->role == 'admin')
        return redirect()->route('dashboard')->with('info', 'Anda sudah login!');
      return redirect()->route('beranda')->with('info', 'Anda sudah login!');
    }

    return $next($request);
  }
}
