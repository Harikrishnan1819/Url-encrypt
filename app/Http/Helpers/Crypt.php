<?php
use Illuminate\Http\Request;
use Closure;

function DecryptValue(Request $request, Closure $next)
{
    $configValue = config('app.crypt_key');

    if (isset($request->query()[$configValue])) {
        $encoded = decrypt_sha_hash256($request->query()[$configValue]);
        return json_decode($encoded);
    }

    return;
}

function EncryptValue($url, $params = null)
{
    if ($params !== null) {
        $encryptedValue = encrypt_sha_hash256(json_encode($params));
        $url .= '?' . config('app.crypt_key') . '=' . $encryptedValue;
    }

    return $url;
}


if (!function_exists('encrypt_sha_hash256')) {
    function encrypt_sha_hash256($string)
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
    function decrypt_sha_hash256($string)
    {
        $textToDecrypt = $string;
        $encrypted = base64_decode($textToDecrypt);
        $password = 'sparkout';
        $key = substr(hash('sha256', $password, true), 0, 32);
        $cipher = 'aes-256-gcm';
        $ivLength = 12; //based on openssl_cipher_iv_length for aes-256-gcm
        $tagLength = 16;
        $iv = substr($encrypted, 0, $ivLength);
        $cipherText = substr($encrypted, $ivLength, -$tagLength);
        $tag = substr($encrypted, -$tagLength);

        return openssl_decrypt($cipherText, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
    }
}