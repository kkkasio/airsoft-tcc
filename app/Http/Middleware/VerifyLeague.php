<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyLeague
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
        $user = Auth::user();


        if (isset($user->profile)) {
            return redirect('404');
        }
        if ($request->path() === "liga/criar") {

            if (isset($user->league->id)) {
                return redirect('404');
            }
        } else {
            if (!isset($user->league->id)) {
                return redirect()->route('criarligaView');
            }
        }
        return $next($request);
    }
}
