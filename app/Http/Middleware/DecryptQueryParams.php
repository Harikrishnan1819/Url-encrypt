<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DecryptQueryParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $encryptedValue = $request->query('enc_val');
        // $configValue = config('app.crypt_key');
        // $routeParameters = $request->query();

        if ($encryptedValue !== null) {
            $decryptedValue = decrypt_sha_hash256($encryptedValue);
            $decryptedArray = json_decode($decryptedValue, true);
            if (is_array($decryptedArray)) {
                $request->merge($decryptedArray);
            }
        }

        // if (empty($routeParameters) || !isset($routeParameters[$configValue])) {
        //     $encryptedValue = encrypt_sha_hash256(json_encode($routeParameters));
        //     $routeParameters[$configValue] = $encryptedValue;
        //     $newUrl = $request->fullUrlWithQuery($routeParameters);

        //     return redirect($newUrl);
        // }

        return $next($request);


    }

}
