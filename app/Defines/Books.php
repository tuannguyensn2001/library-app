<?php


namespace App\Defines;


class Books implements Define
{

    public static function rules(): array
    {
       return [
           'name' => 'required',
           'category_id' => 'required',
           'language' => 'required',
           'quantity' => 'required',
           'description' => 'required',
           'author' => 'required'
       ];
    }

    public static function message(): array
    {
        return [
            'name.required' => trans('books.required.name'),
            'category_id.required' => trans('books.required.category_id'),
            'language.required' => trans('books.required.language'),
            'quantity.required' => trans('books.required.quantity'),
            'description.required' => trans('books.required.description'),
            'author.required' => trans('books.required.author'),
        ];
    }
}
