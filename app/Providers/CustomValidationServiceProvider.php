<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * バリデーションパターン
     *
     * @var array
     */
    protected static $pattern = [
        // 小文字大文字数字が 1 文字以上
        // 8 文字以上 32 文字以下
        'passwordFormat' => '/\A(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[!-~]{8,32}\z/',
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 半角英数のみ。Laravel の alpha_num はマルチバイトが通ってしまう
        Validator::extend('passwordFormat', function ($attribute, $value, $parameters, $validator) {
            return preg_match(self::$pattern['passwordFormat'], $value) === 1;
        });
    }
}
