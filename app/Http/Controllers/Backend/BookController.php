<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Prophecy\Exception\Exception;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->has('type') && $request->query('type') === 'api') {

            $search = $request->query('search');
            $value = $request->query('value');

            $query = Book::query();

//            if ($search === 'id') {
//                $query = $query->where('id', $value);
//            } else if ($search === 'name') {
//                $query = $query->like('name', $value);
//            } else if($search === 'phone'){
//                $query = $query->like('phone', $value);
//            }
            if ($search === 'id') {
                $query = $query->where($search, $value);

            } else if ($search === 'category') {
                $query = $query->where('category_id', $value);
            } else
                $query = $query->like($search, $value);

            return response()->json([
                'data' => $query->get()->map(function ($item) {
                    $item->avatar = asset($item->avatar);
                    return $item;
                })
            ], 200);
        }
        return view('backend.book.index', [
            'books' => Book::with('category')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.book.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BookRequest $request): \Illuminate\Http\RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'thumbnail' => 'file|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(trans('books.file.thumbnail'))->withInput();
        }

        $data = $request->only('name', 'category_id', 'language', 'description', 'quantity', 'author');


        $file = $request->file('thumbnail');
        $thumbnail = Storage::put('public/book', $file);

        $data['thumbnail'] = Storage::url($thumbnail);
        $data['created_by'] = \Illuminate\Support\Facades\Auth::user()->id;
        $data['updated_by'] = \Illuminate\Support\Facades\Auth::user()->id;

        try {
            Book::create($data);
        } catch (\Exception $exception) {
            return back()->with('error', trans('action.create_error'))->withInput();
        }

        return redirect()->route('books.index')->with('success', trans('action.create_success'));

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.book.edit', [
            'book' => Book::find($id),
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BookRequest $request, $id)
    {
        $data = $request->only('name', 'category_id', 'language', 'description', 'quantity', 'author');
        $data['updated_by'] = \Illuminate\Support\Facades\Auth::user()->id;

        if ($request->has('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnail = Storage::put('public/book', $file);

            $data['thumbnail'] = Storage::url($thumbnail);
        }

        try {
            Book::where('id', $id)->update($data);
        } catch (\Exception $exception) {
            dd($exception);
            return back()->with('error', trans('action.edit_error'))->withInput();
        }

        return redirect()->route('books.index')->with('success', trans('action.edit_success'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Book::find($id)->delete();
        } catch (Exception $exception) {
            return response()->json([
                'message' => trans('action.delete_error')
            ], 400);
        }
        Session::flash('success', trans('action.delete_success'));
        return response()->json([], 200);
    }

    public function order($id)
    {
        Session::put('reader_id', \Illuminate\Support\Facades\Auth::user()->reader_id);
        Session::put('book_id', $id);
        return redirect()->route('orders.create');
//      try {
//          Reader::create([
//              ''
//          ])
//      }

    }

}
