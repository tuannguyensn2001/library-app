<?php

namespace App\Http\Controllers\Backend;

use App\Defines\Language;
use App\Exceptions\OrderException;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth;
use App\Http\Requests\OrderRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Reader;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function index()
    {

        return view('backend.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.order.create', [
            'categories' => Category::all(),
            'languages' => json_encode(Language::get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(OrderRequest $request): JsonResponse
    {

        $order = $request->get('order');

        unset($order['reader_name']);
        unset($order['book_name']);

        try {
            $order['from'] = Carbon::createFromFormat('d/m/Y', $order['from']);
            $order['to'] = Carbon::createFromFormat('d/m/Y', $order['to']);

            if ($order['from']->greaterThan($order['to'])) throw new OrderException(trans('order.error_from_greater_to'));

            $order['created_by'] = \Illuminate\Support\Facades\Auth::user()->id;
            $order['updated_by'] = \Illuminate\Support\Facades\Auth::user()->id;
            $order['is_done'] = 0;

            if (\Illuminate\Support\Facades\Session::has('reader_id') && \Illuminate\Support\Facades\Session::has('book_id')) {
                $order['is_check'] = 0;
                \Illuminate\Support\Facades\Session::forget('reader_id');
                \Illuminate\Support\Facades\Session::forget('book_id');
            }

            $book = Book::find($order['book_id']);

            if ($book->quantity < $order['quantity']) throw new OrderException(trans('order.error_enough'));

            Order::create($order);

            $book = Book::find($order['book_id']);
            $book->quantity = $book->quantity - $order['quantity'];
            $book->save();

        } catch (\Exception $exception) {
            if ($exception instanceof OrderException) {
                $message = $exception->getMessage();
            } else {
                $message = trans('action.error');
            }
            return response()->json([
                'message' => $message,
            ], 400);
        }

        return response()->json([
            'message' => trans('action.success'),
            'redirect' => route('orders.index')
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        return view('backend.order.edit', [
            'order' => Order::with('book', 'reader')->where('id', $id)->get()->map(function ($item) {
                $item->from = Carbon::parse($item->from)->format('d/m/Y');
                $item->to = Carbon::parse($item->to)->format('d/m/Y');
                return $item;
            })->first(),
            'categories' => Category::all(),
            'languages' => json_encode(Language::get()),
            'updated_by' => User::find(Order::find($id)->updated_by)->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {

        try {
            $order = Order::find($id);
            $order->is_done = 1;
            $order->updated_by = \Illuminate\Support\Facades\Auth::user()->id;
            $order->done_at = Carbon::now();
            $order->book->quantity = $order->book->quantity + $order->quantity;
            $order->save();
            $order->book->save();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ]);
        }

        \Illuminate\Support\Facades\Session::flash('success', trans('order.edit_success'));

        return response()->json([
            'redirect' => route('orders.index')
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', '05/06/2021');

        $query = Order::with(['reader' => function ($query) {
            return $query->withTrashed();
        }, 'book' => function ($query) {
            return $query->withTrashed();
        }])->orderBy('is_check');

        if ($request->has('reader_name')) {
            $name = Reader::withTrashed()->query()->select('id')->like('name', $request->query('reader_name'))->get()->map(function ($item) {
                return $item->id;
            })->toArray();

            $query->whereIn('reader_id', $name);

        }

        if ($request->has('book_name')) {

            $name = Book::withTrashed()->query()->select('id')->like('name', $request->query('book_name'))->get()->map(function ($item) {
                return $item->id;
            })->toArray();

            $query->whereIn('book_id', $name);
        }

        if ($request->has('from')) {
            $from = Carbon::createFromFormat('d/m/Y', $request->query('from'));
            $query->whereDate('from', $from);
        }

        if ($request->has('to')) {
            $from = Carbon::createFromFormat('d/m/Y', $request->query('to'));
            $query->whereDate('to', $from);
        }

        if ($request->has('reader_id')) {
            $query->where('reader_id', $request->query('reader_id'));
        }

        if ($request->has('book_id')) {
            $query->where('book_id', $request->query('book_id'));

        }

        if ($request->has('is_done')) {
            $query->where('is_done', $request->query('is_done'));
        }

        if ($request->has('created_by')) {
            $query->where('created_by', \Illuminate\Support\Facades\Auth::user()->id);
        }

        if ($request->has('updated_by')) {
            $query->where('updated_by', \Illuminate\Support\Facades\Auth::user()->id);
        }

        $data = $query->get()->map(function ($item) {
            $object = (object)$item->toArray();

            if ($item->is_done === 1) $object->status = 'DONE';
            else {
                $to = Carbon::parse($item->to);

                if (Carbon::now()->greaterThan($to)) {
                    $object->status = 'LATE';
                } else {
                    $object->status = 'NOT_DONE';
                }
            }

            $object->from = Carbon::parse($item->from)->format('d/m/Y');
            $object->to = Carbon::parse($item->to)->format('d/m/Y');
            $object->created_at = Carbon::parse($item->created_at)->format('d/m/Y H:i');
            $object->updated_at = Carbon::parse($item->updated_at)->format('d/m/Y H:i');


            return $object;


        });


        return response()->json([
            'data' => $data
        ], 200);


    }

    public function check($id)
    {
        $order = Order::findOrFail($id);

        $order->is_check = 1;

        $order->save();

        return redirect()->back()->with('success', trans('action.check_success'));

    }

}
