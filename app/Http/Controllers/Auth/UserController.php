<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()
            ], 400);
        }

        try {
            $user =  User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email' => $request->email
            ]);

            if ($user) {
                return response()->json([
                    'message' => "Successfully create"
                ], 201);
            }

            return response()->json([
                'message' => 'Fail create'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Fail create',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if($user->tokens()){
                    $user->tokens()->delete();
                };

                $token =$user->createToken('userAuthPhitPrTl',['role:user'])->plainTextToken;
                return response()->json([
                    'message' => 'Login successfully',
                    'token' => $token

                ], 201);
            }


            return response()->json([
                'message' => 'Login fail'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Login fail',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
