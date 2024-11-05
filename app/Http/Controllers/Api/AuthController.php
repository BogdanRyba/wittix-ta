<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly AuthService $authService
    )
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $userDTO = new UserDTO($request->validated());
        $user = $this->userService->createUser($userDTO);

        return response()->json(['message' => 'Registration successful.'], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!$this->authService->login($request->validated())) {
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.'], 200);
    }


    public function showLoginPage()
    {
        return view('auth.login');
    }

    public function showRegisterPage()
    {
        return view('auth.register');
    }
}
