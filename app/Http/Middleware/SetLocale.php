<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supportedLocales = ['mk'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->getLocale($request);

        if ($locale && in_array($locale, $this->supportedLocales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        }

        return $next($request);
    }

    protected function getLocale(Request $request): ?string
    {
        // Always return Macedonian
        return 'mk';
    }
}