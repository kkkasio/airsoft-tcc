<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyMember
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
        if ($request->path() === "membro/criar") {

            if (isset($user->profile->id)) {
                return redirect('404');
            }
        } else {
            if (!isset($user->profile->id)) {
                return redirect()->route('criarProfileView');
            }
        }
        return $next($request);

    }
}
