<?php

namespace App\Http\Middleware;

use Closure;

class Editor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user && ($user->role === 'admin' || $user->role === 'editor')) {
            return $next($request);
        }

        return redirect()->route('system.login');
    }
}
