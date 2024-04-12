<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptQueryParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Get all query parameters
        $queryParams = $request->query();

        // Encrypt each query parameter's value
        foreach ($queryParams as $key => $value) {
            $encryptedValue = Crypt::encryptString($value);
            $request->query->set($key, $encryptedValue);
        }

        return $next($request);
    }
}
