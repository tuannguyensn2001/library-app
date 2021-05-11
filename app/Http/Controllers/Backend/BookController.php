<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $file = $request->file('thumbnail');
        $data = $request->only('name', 'category_id', 'language', 'description', 'quantity', 'author');

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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
