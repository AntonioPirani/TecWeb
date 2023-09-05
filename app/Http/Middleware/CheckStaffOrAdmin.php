<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStaffOrAdmin
{
    /**
     * Utilizzato per definire l'accesso alle pagine condivise tra admin e staff
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && ($request->user()->isAdmin() || $request->user()->isStaff())) {
            return $next($request);
        }

        return redirect('/');
    }
}
