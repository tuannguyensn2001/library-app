<?php


namespace App\Defines;


interface Define
{
    public static function rules(): array;
    public static function message(): array;
}
