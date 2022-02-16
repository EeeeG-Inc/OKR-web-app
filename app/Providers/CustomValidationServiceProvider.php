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
        // 半角英数字・記号をそれぞれ 1 種類以上含む 8 文字以上 32 文字以下の正規表現
        'passwordFormat' => '/\A(?=.*?[a-z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{8,32}+\z/i',
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
