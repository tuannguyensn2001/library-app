<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth;
use App\Http\Requests\ReaderRequest;
use App\Models\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReaderController extends Controller
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

            $query = Reader::query();

            if ($search === 'id') {
                $query = $query->where('id', $value);
            } else if ($search === 'name') {
                $query = $query->like('name', $value);
            } else if($search === 'phone'){
                $query = $query->like('phone', $value);
            }

            return response()->json([
                'data' => $query->get()->map(function($item){
                    $item->avatar = asset($item->avatar);
                    return $item;
                })
            ], 200);
        }
        return view('backend.reader.index', [
            'readers' => Reader::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.reader.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReaderRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->only('name', 'address', 'phone');
        $data['avatar'] = 'https://i.pinimg.com/originals/d8/ca/c7/d8cac7903de22dad05d9f17ace441d97.jpg';
        $data['created_by'] = \Illuminate\Support\Facades\Auth::user()->id;
        $data['updated_by'] = \Illuminate\Support\Facades\Auth::user()->id;
        try {
            Reader::create($data);
        } catch (\Exception $exception) {
            return back()->with('error', trans('readers.create_error'))->withInput();
        }
        return redirect()->route('readers.index')->with('success', trans('readers.create_success'));
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(int $id)
    {
        $reader = Reader::find($id);
        if (is_null($reader)) return redirect()->route('readers.index')->with('error', trans('action.not_found', ['name' => trans('readers.index_name')]));

        return view('backend.reader.edit', [
            'reader' => Reader::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ReaderRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReaderRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $data = $request->only('name', 'address', 'phone');
        $data['updated_by'] = \Illuminate\Support\Facades\Auth::user()->id;
        try {
            Reader::query()
                ->where('id', $id)->update($data);
        } catch (\Exception $exception) {
            return back()->with('error', trans('readers.edit_error'))->withInput();
        }
        return redirect()->route('readers.index')->with('success', trans('readers.edit_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $reader = Reader::find($id);

        if (is_null($reader)) return response()->json([
            'message' => trans('action.not_found', ['name' => 'độc giả'])
        ], 400);

        try {
            Reader::find($id)->delete();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('action.delete_error')
            ], 400);
        }

        Session::flash('success', trans('action.delete_success'));
        return response()->json([], 200);


    }
}
