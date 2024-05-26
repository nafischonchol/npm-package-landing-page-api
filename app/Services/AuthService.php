<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($request)
    {
        try {
            $user = User::where("email",$request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw new \Exception('Credential not match!');
            }
            $user['token'] = $user->createToken('npm-package-landing')->plainTextToken;
            
            return response()->json($user);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json($th->getMessage(), 500);
        }
    }
}
