<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MessageMiddleware
{
    /**
     * Utilizzato per permettere l'accesso alla pagina di messaggi di user e admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && ($request->user()->isAdmin() || $request->user()->isUser())) {
            return $next($request);
        }

        return redirect('/');
    }
}
