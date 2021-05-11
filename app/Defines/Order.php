<?php


namespace App\Defines;


class Order implements Define
{

    public static function rules(): array
    {
        return [
            'order.reader_id' => 'required',
            'order.book_id' => 'required'
        ];
    }

    public static function message(): array
    {
        return [
            'order.reader_id.required' => 'Độc giả không được để trống'
        ];

    }
}
