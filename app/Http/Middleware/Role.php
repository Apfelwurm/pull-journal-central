<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRoleEnum;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {


        if (Auth::check() ){
            $roles = explode("|", $roles);
            $valid = false;
            foreach ($roles as $role) {

                if ($role === UserRoleEnum::SUPERADMIN->value && Auth::user()->isSuperAdmin())
                {
                        $valid = true;
                }

                if ($role === UserRoleEnum::DEVICEADMIN->value && Auth::user()->isDeviceAdmin())
                {
                        $valid = true;
                }

                if ($role === UserRoleEnum::VIEWER->value && Auth::user()->isViewer())
                {
                        $valid = true;
                }

            }
            if ($valid)
            {
                return $next($request);
            }
        }

        return redirect('/');
    }
}
