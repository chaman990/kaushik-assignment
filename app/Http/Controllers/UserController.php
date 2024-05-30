<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function store(CreateUserRequest $request)
    {
        // Validation logic here

        $user = new User();
        // Assign request data to user attributes
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->description = $request->description;
        $user->role_id = $request->roleId;
        // Save profile image to storage
        // $request->file('profile_image')->store('images');
        $user->profile_image = str_replace("public","storage",$request->file('profileImage')->store('public'));
        $user->save();

        return response()->json($user, 201);
    }

    public function index()
    {
        $users = User::with('role')->get();
        return response()->json($users, 200);
    }
}