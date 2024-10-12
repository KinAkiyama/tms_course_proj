<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enum\UserRoles;
use App\Enum\UserStatus;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|unique:users',
            'username' => 'required|string|min:3|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'lastSignAt' => now(),
            'roles' => json_encode([UserRoles::User]),
            'status' => UserStatus::Active->value,
        ]);

        return response()->json(['user' => $user], 201);
    }
}
