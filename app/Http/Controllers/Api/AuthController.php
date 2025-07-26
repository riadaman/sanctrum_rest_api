<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Helper\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{


    /**
     * register new user.
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
            ]);
            if($user){
             return   ResponseHelper::success(
                    $user,
                    'User registered successfully',
                    'success',
                    201
                );
            }
            return   ResponseHelper::error(
                'User registration failed',
                'error',
                400
                );
        } catch (user $e) {
            Log::error('User registration failed: ' . $e->getMessage()) . '-Line: ' . $e->getLine();
             return   ResponseHelper::error(
                'User registration failed',
                'error',
                500
                );
        }
    }


    /**
     * Function to handle user login.
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
       try{
            if(!Auth::attempt(['email' => $request->email,'password' => $request->password,])){
                return ResponseHelper::error(
                    'Invalid credentials',
                    'error',
                    401
                );
            }
            $user = Auth::user();
            // dd($user);
            // create a new token for the user
            $token = $user->createToken('auth_token')->plainTextToken;
            return ResponseHelper::success(
                [
                    'user' => $user,
                    'token' => $token
                ],
                'User logged in successfully',
                'success',
                200
            );
       }
         catch (Exception $e) {
                Log::error('User login failed: ' . $e->getMessage() . '-Line: ' . $e->getLine());
                return ResponseHelper::error(
                 'User login failed',
                 'error',
                 500
                );
          }
    }

}
