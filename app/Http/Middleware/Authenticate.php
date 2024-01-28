<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            $adminGuard = 'admin';
            $userGuard = 'web';

            // Redirect to admin login if not authenticated in admin guard
            if ($request->routeIs('admin.*') && !$request->user($adminGuard)) {
                return route('admin.login');
            }

            // Redirect to user login if not authenticated in the general guard
            if ($request->routeIs('user.*') && !$request->user($userGuard)) {
                return route('user.login');
            }

            // If authenticated in admin guard, redirect to admin dashboard for user routes
            if ($request->user($adminGuard) && $request->routeIs('user.*')) {
                return route('admin.dashboard');
            }

            // If authenticated in general guard, redirect to user dashboard for admin routes
            if ($request->user($userGuard) && $request->routeIs('admin.*')) {
                return route('user.dashboard');
            }
        }
    }
}
