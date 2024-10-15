<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    //
    public function login (Request $request) {
        $email = $request->email;
        $password = $request->password;
        if(Auth::attempt([
            'email' => $email,
            'password' => $password
        ])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'status' => 200,
                'token' =>$token
            ];
        }else {
            $response = [
                'status' => 401,
                'title' => 'Unauthorized'
            ];
        }
        return $response;
    }

    public function getToken (Request $request) {
        dd(Auth::id()) ;
        return $request->user()->currentAccessToken()->delete();
    }

    public function refreshToken (Request $request) {
        $hashToken = str_replace('Bearer ', '', $request->header('authorization'));
        $hashToken = trim($hashToken);
        $token = PersonalAccessToken::findToken($hashToken);
        if($token) {
            $tokenCreated = $token->created_at;
            $expire = Carbon::parse($tokenCreated)->addMinutes(config('sanctum.expiration'));
            if(Carbon::now() >= $expire) {
                $userId = $token->tokenable_id;
                $user = User::find($userId);
                $user->tokens()->delete();
                $newToken = $user->createToken('auth_token')->plainTextToken;
                $response = [
                    'status' => 200,
                    'token' => $newToken
                ];
            }else{
                $response = [
                    'status' => 200,
                    'title' => 'Unexpired'
                ];
            }
        }else{
            $response = [
                'status' => 401,
                'title' => 'Unauthorized'
            ];
        }
        return $response;
    }
}
