<?php

namespace App\Http\Controllers\Api;

use App\Car;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return response()->json(
            User::with('cars')->paginate(10)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
//    public function create(Request $request)
//    {
//        return response()->json(['create','user']);
//    }


    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function saveNewUser(UserRequest $request)
    {
        if ($request->json()) {
            $newUser = User::create($request->except(['confirmation', 'errors']));
            if ($newUser) {

                return response()->json([
                    'success' => 'New User created successfully'
                ]);
            }
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->json()) {
            return response()->json(User::all());
        }
        return abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Get User from db and return them and cars
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->json(
            User::with('cars')
                ->where('id', $user->id)->first()
        );
    }

    /**
     * Update User in db.
     *
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if ($user->update($request->except('confirmation', 'errors', 'id'))) {

            return response()->json([
                'success' => 'User updated successfully'
            ]);
        }
        return abort(403);

    }

    /**
     * Remove User from db.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user) {
            Car::where('user_id', $user->id)->delete();
            $user->delete();

            return response()->json([
                'success' => 'User deleted successfully'
            ]);
        }
        return abort(403);
    }
}
