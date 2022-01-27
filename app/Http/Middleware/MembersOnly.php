<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MembersOnly
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
        if ($request->project && ! $request->project->team->findUser(auth()->user()))
            abort(403, 'You have to be a member so have access to this project');

        return $next($request);
    }
}
