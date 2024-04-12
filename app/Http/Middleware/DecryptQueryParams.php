<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DecryptQueryParams
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

        // Decrypt each query parameter's value
        foreach ($queryParams as $key => $value) {
            try {
                $decryptedValue = Crypt::decryptString($value);
                $request->query->set($key, $decryptedValue);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Handle decryption errors
                // You may log the error or take appropriate action
            }
        }

        return $next($request);
    }
}
