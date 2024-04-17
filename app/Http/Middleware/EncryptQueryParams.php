<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EncryptQueryParams
{
    public function handle($request, Closure $next)
    {
        // // dd($request->query()["ENC_VAL"]);
        // $encryptedValue = $request->query('ENC_VAL');
        // $decryptedValue = $this->decrypt_sha_hash256($encryptedValue);
        // $decryptedArray = json_decode($decryptedValue, true);
        // $request->merge(['decrypted_value' => $decryptedArray]);
        // return $next($request);


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

    public static function encrypt_sha_hash256($string)
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

    // public function terminate($request, $response)
    // {
    //     // dd(31);
    //     $configValue = config('app.crypt_key');

    //     if (isset($request->query()[$configValue])) {
    //         $encoded = $this->decrypt_sha_hash256($request->query()[$configValue]);
    //         // dd($encoded);
    //         // $request->merge(['decrypted_data' => $encoded]);
    //         return json_decode($encoded);
    //     }
    //     return;
    //     // $decryptedData = DecryptValue($request);
    //     // // dd($decryptedData);
    //     // $request->merge(['decrypted_data' => $decryptedData]);

    // }
    public function decrypt_sha_hash256($string)
    {
        $textToDecrypt = $string;
        $encrypted = base64_decode($textToDecrypt);
        $password = 'sparkout';
        $key = substr(hash('sha256', $password, true), 0, 32);
        $cipher = 'aes-256-gcm';
        $ivLength = 12;
        $tagLength = 16;
        $iv = substr($encrypted, 0, $ivLength);
        $cipherText = substr($encrypted, $ivLength, -$tagLength);
        $tag = substr($encrypted, -$tagLength);

        return openssl_decrypt($cipherText, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
    }
}