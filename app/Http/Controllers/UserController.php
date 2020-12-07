<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {

        // validation
        $validator      =       Validator::make(
            $request->all(),
            [
                'username'          =>     'required|string',
                'password'          =>     'required|string'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user       =       Auth::user();
            $token      =       $user->createToken('token')->accessToken;

            return response()->json([
                "status" => 200,
                "success" => true,
                "login" => true,
                "token" => $token,
                "data" => $user]);
        } else {
            return response()->json([
                "status" => "failed",
                "success" => false,
                "message" => "Login error"]);
        }
    }

    public function doLogin() {
        return response()->json(['message' => 'you must login'], 403);
    }
}
