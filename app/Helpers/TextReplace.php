<?php

namespace App\Helpers;

/**
 * URLが含まれていた場合、リンク化する
 * @param string|null $value
 * @return string|null
 */
class TextReplace {
    public static function urlReplace(?string $value): ?string
    {
        if(is_null($value)){
            return $value;
        }

        $texts = explode(PHP_EOL, $value);
        $pattern = '/https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/';
        $replacedTexts = [];

        foreach ($texts as $value) {
            $replace = preg_replace_callback($pattern, function ($matches) {
                if (isset($matches[1])) {
                    return $matches[0];
                }
                return '<a href="' . $matches[0] . '" target="_blank" rel="noopener">' . $matches[0] . '</a>';
            }, $value);
            $replacedTexts[] = $replace;
        }
        return implode(PHP_EOL, $replacedTexts);
    }
}
