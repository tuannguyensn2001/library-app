<?php


namespace App\Defines;


class Language
{
    const _VIETNAMESE = 'VIETNAMESE';
    const _ENGLISH = 'ENGLISH';

    public static function get()
    {
        return [
            self::_VIETNAMESE => 'Tiếng Việt',
            self::_ENGLISH => 'Tiếng Anh'
        ];
    }

    public static function find($language)
    {
        $language = strtolower($language);
        return trans("language.{$language}");
    }



}
