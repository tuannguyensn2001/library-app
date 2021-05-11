<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.user.index',[
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->get('user');

        $user['password'] = Hash::make($user['password']);

        try {
            $user = User::create($user);
        } catch(\Exception $exception){

            return response()->json([
                'message' => trans('action.create_error')
            ],400);
        }
        return response()->json([
            'message' => trans('action.create_success'),
            'data' => $user
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = $request->get('user');

        unset($user['id']);

        try {
            $user = User::find($id);
            $user->name = $user['name'];
            $user->is_active = $user['is_active'];
            $user->is_admin = $user['is_admin'];
            $user->save();
        } catch(\Exception $exception){
            return response()->json([
                'message' => trans('action.edit_error')
            ],400);
        }
        return response()->json([
            'message' => trans('action.edit_success'),
            'data' => User::find($id),
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
