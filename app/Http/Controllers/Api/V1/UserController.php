<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserValidationRequest;
use App\Http\Requests\UpdateUserValidationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => "success",
            'message' => 'Users List Retrieved Successfully',
            'data' => UserResource::collection(User::all()),
        ], 200);

    }

    public function store(CreateUserValidationRequest $request)
    {
        $input = $request->validated();
        $password = $request->password;
        $input['password'] = bcrypt($password);

        $user = User::create($input);

        return response()->json([
            'status' => "success",
            'message' => 'User has been registered Successfully',
            'data' => new UserResource($user),
        ], 201);

    }

    public function show(User $user)
    {
        if ($user == null) {
            return response()->json([
                'status' => "failed",
                'message' => 'User does not exist',

            ], 400);
        } else {
            return response()->json([
                'status' => "success",
                'message' => 'User has been retrieved',
                'data' => new UserResource($user),
            ], 200);
        }

    }

    public function update(UpdateUserValidationRequest $request, User $user)
    {
        $input = $request->validated();

        $user->update($input);

        return response()->json([
            'status' => "success",
            'message' => 'User has been updated Successfully',
            'data' => new UserResource($user),
        ], 200);

    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => "success",
            'message' => 'User has been deleted Successfully',

        ], 204);

    }
}
