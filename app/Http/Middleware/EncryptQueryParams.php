<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;

class EncryptQueryParams
{
    public function handle($request, Closure $next)
    {
        $configValue = config('app.crypt_key');
        $routeParameters = $request->query();

        if (!empty($routeParameters)) {
            if (!isset($routeParameters[$configValue])) {
                $encryptedValue = $this->encrypt_sha_hash256(json_encode($routeParameters));
                $request->query->set($configValue, $encryptedValue);
                $request->query->replace([$configValue => $encryptedValue]);
                $newUrl = $request->fullUrlWithQuery($request->query->all());

                return redirect($newUrl);
            }
        }
        return $next($request);
    }

    public function encrypt_sha_hash256($string)
    {
        $textToEncrypt = $string;
        $password = 'sparkout';
        $key = substr(hash('sha256', $password, true), 0, 32);
        $cipher = 'aes-256-gcm';
        $ivLength = 12; //based on openssl_cipher_iv_length for aes-256-gcm
        $tagLength = 16;
        $iv = openssl_random_pseudo_bytes($ivLength);
        $tag = ""; // will be filled by openssl_encrypt
        $cipherText = openssl_encrypt($textToEncrypt, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag, "", $tagLength);
        $encrypted = base64_encode($iv . $cipherText . $tag);
        return $encrypted;
    }
}