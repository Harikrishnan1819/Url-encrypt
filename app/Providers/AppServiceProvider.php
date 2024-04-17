<?php

namespace App\Providers;

use App\Http\Middleware\EncryptQueryParams;
use Illuminate\Http\Request;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EncryptQueryParams::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        // dd($request->all());
        $configValue = config('app.crypt_key');

        if (isset($request->query()[$configValue])) {
            $request = $this->decrypt_sha_hash256($request->query()[$configValue]);
            return json_decode($request);
        }
    }
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
