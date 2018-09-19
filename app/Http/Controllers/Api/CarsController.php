<?php

namespace App\Http\Controllers\Api;

use App\Car;
use App\Http\Requests\CarRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Car[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return response()->json(
            Car::with('user')->paginate(10)
        );
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
     * @param CarRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequest $request)
    {
        if ($request->json()) {
            $newCar = Car::create($request->except(['errors', 'users']));
            if ($newCar) {

                return response()->json([
                    'success' => 'New Car created'
                ]);
            }
            return response()->json([
                'warning' => 'Warning create new Car'
            ]);
        }
        return abort(403);

    }

    /**
     * Get all users
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request)
    {
        if ($request->json()) {
            return response()->json(User::all());
        }
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
     * Get car and return with user json
     *
     * @param Car $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        return response()->json([
            Car::with('user')
                ->where('id', $car->id)->first(),
            User::all()
        ]);
    }

    /**
     * Update Car in db.
     *
     * @param CarRequest $request
     * @param Car $car
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequest $request, Car $car)
    {
        if ($car->update($request->except('users', 'errors'))) {

            return response()->json([
                'success' => 'Car updated successfully'
            ]);
        }
        return abort(403);

    }

    /**
     * Remove Car from db.
     *
     * @param Car $car
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Car $car)
    {
        if ($car->delete()) {

            return response()->json([
                'success' => 'Car deleted successfully'
            ]);
        }
    }
}
