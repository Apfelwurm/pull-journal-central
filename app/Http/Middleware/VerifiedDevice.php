<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class VerifiedDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (get_class(Auth::user()) != "App\Models\Device")
        {
            $message = "This Bearer Key does not belong to a valid Device";
            $response = [
                'message' => $message,
                'errors' => [
                    'device verification' => [
                        $message,
                    ],
                ],
            ];


            return response()->json($response, 401);
        }




        if (!isset(Auth::user()->verified_at))
        {
            $message = "This device was not verified";
            $response = [
                'message' => $message,
                'errors' => [
                    'device verification' => [
                        $message,
                    ],
                ],
            ];


            return response()->json($response, 401);
            }

        Auth::user()->last_api_call = Carbon::now();
        Auth::user()->save();
        return $next($request);
    }
}
