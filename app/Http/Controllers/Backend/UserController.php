<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.user.index', [
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

        $user['avatar'] = 'https://www.lewesac.co.uk/wp-content/uploads/2017/12/default-avatar.jpg';

        try {
            $user = User::create($user);
        } catch (\Exception $exception) {

            return response()->json([
                'message' => trans('action.create_error')
            ], 400);
        }
        return response()->json([
            'message' => trans('action.create_success'),
            'data' => $user
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
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $users = $request->get('user');

        unset($users['id']);

        try {
            $user = User::find($id);
            $user->name = $users['name'];
            $user->is_active = $users['is_active'];
            $user->is_admin = $users['is_admin'];
            $user->reader_id = $users['reader_id'];

            $user->save();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('action.edit_error')
            ], 400);
        }
        return response()->json([
            'message' => trans('action.edit_success'),
            'data' => User::find($id),
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            User::find($id)->delete();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('action.delete_error')
            ], 400);
        }
        return response()->json([], 200);
    }

    public function profile()
    {
        return view('backend.user.profile');
    }

    public function updateProfile(UserRequest $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');

        try {
            Auth::user()->name = $name;
            Auth::user()->password = Hash::make($password);
            Auth::user()->save();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', trans('action.edit_error'));
        }

        return redirect()->back()->with('success', trans('action.edit_success'));
    }

    public function avatar(Request $request)
    {
        $file = $request->file('avatar');
        $avatar = Storage::put('/public/user', $file);

        try {
            Auth::user()->avatar = Storage::url($avatar);
            Auth::user()->save();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('action.edit_error')
            ], 400);
        }

        return response()->json([
            'message' => trans('action.edit_success')
        ], 200);
    }

}
