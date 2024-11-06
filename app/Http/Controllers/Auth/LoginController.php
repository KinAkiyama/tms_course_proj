<?php

namespace App\Http\Controllers\Auth;

use App\Enum\UserStatus;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->status = UserStatus::Active->value;
                $user->save();

                $token = $user->createToken(time())->plainTextToken;
                return response()->json(['user' => $user, 'token' => $token], 200);
            }
        }
        return response()->json(['error' => 'Incorrect email or password'], 401);
    }

    public function logout()
    {
        $user = User::find(Auth::id());
        if (!Auth::check()) {
            return response()->json(['error' => 'User is not authenticated'], 401);
        }
        if ($user) {
            $user->status = UserStatus::Inactive->value;
            if ($user->save()) {
                return response()->json(['message' => 'Successfully logged out'], 200);
            } else {
                return response()->json(['error' => 'Failed to save user status'], 500);
            }
        }
        return response()->json(['error' => 'Something happend'], 401);
    }
}

