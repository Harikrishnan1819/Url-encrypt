<?php

// app/Helpers/EncryptionHelper.php

use Illuminate\Http\Request;

function DecryptValue(Request $request)
{
    $configValue = config('app.crypt_key');

    if (isset($request->query()[$configValue])) {
        $encoded = decrypt_sha_hash256($request->query()[$configValue]);
        return json_decode($encoded);
    }

    return;
}

if (!function_exists('decrypt_sha_hash256')) {
    function decrypt_sha_hash256($string)
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
