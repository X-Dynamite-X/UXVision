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
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search', '');

        // Validate and limit the per_page parameter
        $perPage = in_array($perPage, [5, 10, 15, 25, 50]) ? $perPage : 10;

        $users = User::query()
            ->select(['id', 'name', 'email', 'created_at'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'asc')
            ->paginate($perPage)
            ->through(fn($user)=>
            [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            ])
            ->withQueryString();

        return Inertia::render('Admin/Users', [
            'users' => $users,
            'filters' => [
                'per_page' => $perPage,
                'search' => $search,
            ],
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
