<?php


namespace App\Defines;


class Reader implements Define
{
    public static function rules(): array
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ];
    }

    public static function message(): array
    {
        return [
            'name.required' => trans('readers.name_required'),
            'address.required' =>  trans('readers.address_required'),
            'phone.required' =>  trans('readers.phone_required'),
        ];
    }
}
