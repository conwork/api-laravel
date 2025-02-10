<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserPreferences
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && isset($request->user()->preferences['locale'])) {
            $locale = $request->user()->preferences['locale'];

            // Verificar si el idioma es válido en la configuración
            if (in_array($locale, config('app.available_locales', ['en', 'es']))) {
                // Cambiar el idioma en Laravel y en el paquete de localización
                App::setLocale($locale);
                LaravelLocalization::setLocale($locale);
            }
        }
        return $next($request);
    }
}
