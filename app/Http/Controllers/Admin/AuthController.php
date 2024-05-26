<?php

namespace App\Http\Controllers\Admin;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }
}
