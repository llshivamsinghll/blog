<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    private $jwtSecret;
    private $jwtExpiry;

    public function __construct()
    {
        $this->jwtSecret = env('JWT_SECRET');
        $this->jwtExpiry = env('JWT_EXPIRES_IN', 3600); // Default 1 hour
    }

    private function signToken($userId)
    {
        $payload = [
            'iss' => 'your-app-name', // Issuer
            'sub' => $userId,        // Subject
            'iat' => time(),         // Issued at
            'exp' => time() + $this->jwtExpiry, // Expiry
        ];

        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'nullable|string|in:user,admin'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role', 'user'),
        ]);

        $token = $this->signToken($user->id);

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ],
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect email or password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $this->signToken($user->id);

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ],
        ], Response::HTTP_OK);
    }

    public function protect(Request $request)
    {
        $authorization = $request->header('Authorization');

        if (!$authorization || !str_starts_with($authorization, 'Bearer ')) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = substr($authorization, 7); // Remove 'Bearer ' prefix

        try {
            $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::find($decoded->sub);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User no longer exists',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $request->merge(['user' => $user]);
        return $next($request);
    }
}
