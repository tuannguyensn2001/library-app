<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth;
use App\Models\Book;
use App\Models\Order;
use App\Models\Reader;
use Barryvdh\Debugbar\Facade;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['order_not_done'] = Order::all()->filter(function ($item) {
            $done = Carbon::parse($item->done_at);
            $to = Carbon::parse($item->to);
            return $done->greaterThan($to);
        })->map(function ($item) {
            return $item->book_id;
        })->unique()->count();


        $data['books'] = Book::all()->count();
        $data['reader_ordering'] = Order::query()->select('reader_id')->where('is_done', 0)->groupBy('reader_id')->get()->count();
        $data['reader_order_late'] = Order::all()->filter(function ($item) {
            $done = Carbon::parse($item->done_at);
            $to = Carbon::parse($item->to);
            return $done->greaterThan($to);
        })->map(function ($item) {
            return $item->reader_id;
        })->unique()->count();

        return view('backend.index', [
            'data' => $data
        ]);
    }

    public function login()
    {
        if (\Illuminate\Support\Facades\Auth::check()) return redirect()->route('index');
        return view('backend.auth.login');
    }

    public function signIn(Request $request): \Illuminate\Http\RedirectResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = !is_null($request->input('remember'));

        if (\Illuminate\Support\Facades\Auth::attempt([
            'email' => $email,
            'password' => $password,
        ], $remember)) {
            return redirect()->route('index');
        }

        return redirect()->back()->with('error', trans('auth.signIn_error'));

    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        \Illuminate\Support\Facades\Auth::logout();

        return redirect()->route('index');
    }

    public function statistic(Request $request)
    {
        $type = $request->query('type');

        $data = [];

        switch ($type) {
            case 'order_not_done':
                $data = Order::all()->filter(function ($item) {
                    $done = Carbon::parse($item->done_at);
                    $to = Carbon::parse($item->to);
                    return $done->greaterThan($to);
                })->map(function ($item) {
                    return $item->book_id;
                })->unique()->map(function($item){
                    return Book::find($item);
                })->filter(function ($item) {
                    return !is_null($item);
                });
                break;

            case 'books':
                $data = Book::all();
                break;


            case 'reader_ordering':
                $data = Order::query()->select('reader_id')->where('is_done', 0)->groupBy('reader_id')->get()->map(function ($item) {
                    return Reader::find($item->reader_id);
                });

                break;

            case 'reader_order_late':
                $data =Order::all()->filter(function ($item) {
                    $done = Carbon::parse($item->done_at);
                    $to = Carbon::parse($item->to);
                    return $done->greaterThan($to);
                })->map(function ($item) {
                    return $item->reader_id;
                })->unique()->map(function($item){
                    return Reader::find($item);
                })->filter(function ($item) {
                    return !is_null($item);
                });
                break;

        }

        return view('backend.statistic', [
            'data' => $data,
            'type' => $type,
        ]);

    }

}
