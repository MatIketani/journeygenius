<?php

namespace App\Http\Middleware;

use App\Models\Auth\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    const DEFAULT_LOCALE = 'en';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var User $currentUser
         */
        $currentUser = auth()->user();

        if ($currentUser) {

            app()->setLocale($currentUser->locale?->code ?: self::DEFAULT_LOCALE);
        }

        return $next($request);
    }
}
