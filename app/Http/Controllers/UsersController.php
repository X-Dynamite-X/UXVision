<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\Admin\Users\{StoreRequest, UpdateRequest};

use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Admin/Users', [
            'users' => User::all()

        ]);
    }


    public function store(StoreRequest $request)
    {
        User::create(
            [
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),

            ]
        );

        // return to_route("users.index") ;
        return Redirect::back();
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->all());
        return to_route("users.index");
    }


    public function destroy(User $user)
    {
        $user->delete();
        return to_route("users.index");
    }
}
