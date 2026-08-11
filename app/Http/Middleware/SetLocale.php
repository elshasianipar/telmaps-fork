<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Resolve the requested locale from ?lang= (defaulting to Indonesian) and
     * make it available to every public view as $lang.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->query('lang') === 'en' ? 'en' : 'id';

        app()->setLocale($lang);
        View::share('lang', $lang);

        return $next($request);
    }
}
