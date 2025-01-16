<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Http\Resources\UserResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $users = User::all();
        return $this->response('List of users retrieved successfully.', 200, UserResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return $this->error('Invalid data', 400, $validator->errors());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return $this->response('User created successfully.', 201, new UserResource($user));
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->response('User details retrieved successfully.', 200, new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return $this->error('Invalid data', 400, $validator->errors());
        }

        try {
            $user->update($request->only(['name', 'email']));
            return $this->response('User updated successfully.', 200, new UserResource($user));
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {    
        try {
            $user->delete();
            return $this->response('User deleted successfully.', 200);
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }
}