<?php

namespace App\Http\Middleware;

use Closure;

class RestrictUser
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
        $loggedUser = getCurrentUser();
        if ($loggedUser->checkIsSuperAdmin()) {
            return $next($request);
        }

        if (!$loggedUser->checkHasAnyRoles(['admin', 'mod'])) {
            return redirect()->route('home');
        }

        $acl = \AclAdapter::getInstance();
        $acl->restrictUser();

        return $next($request);
    }
}
