<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Helper\ResponseHelper;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
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
                400
                );
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

}
