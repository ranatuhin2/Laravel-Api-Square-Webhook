<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email',$request->email)->first();
        if(is_null($user)){
            return response()->json([
                'message'=>'user not Found!'
            ]);
        }
        if(! password_verify($request->password, $user->password)){
            return response()->json([
                'token' => 'Password not Matched!'
            ]);
        }
        $token = $user->createToken('api')->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }

    public function register(RegisterRequest $request, AuthService $authService): User
    {   
        $user = $authService->create($request);
        return $user;
    }
}
