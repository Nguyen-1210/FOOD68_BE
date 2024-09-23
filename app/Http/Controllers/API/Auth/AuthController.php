<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;  

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->middleware('throttle:5,1')->only('login');
    }

    /**
     * Login user
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return jsonResponse(null, 401, 'Unauthorized');
            }
            $refresh_token = $this->createRefreshToken();

            return $this->respondWithToken($token, $refresh_token, 'Login successful');
        } catch (JWTException $e) {
            return jsonResponse($e->getMessage(), 500, 'Could not create token');
        }
    }

    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return jsonResponse(null, 200, 'Logout successfully');
    }

    public function refresh(Request $request): JsonResponse
    {
        $refresh_token = $request->refresh_token;
        try {
            $decode = JWTAuth::getJWTProvider()->decode($refresh_token);
            $user = User::find($decode['user_id']);
            $key_token = $decode['key_token'];
            if (!$user) {
                return jsonResponse(null, 404, 'User not found');
            }

            if (!password_verify(env('SECRET_KEY_TOKEN'), $key_token)) {
                return jsonResponse(null, 401, 'Unauthorized');
            }

            auth('api')->invalidate();
            $token = auth('api')->login($user);
            $refresh_token = $this->createRefreshToken();
            return $this->respondWithToken($token, $refresh_token, 'Refresh token successful');
        } catch (JWTException $exception) {
            return jsonResponse(null, 500, 'Refresh Token Invalid');
        }
    }

    private function respondWithToken(string $token, string $refresh_token, string $message)
    {
        $role = Auth::user()->getRoleNames()->first();
        return jsonResponse([
            'user_id' => Auth::user()->id,
            'role' => $role,
            'access_token' => $token,
            'refresh_token' => $refresh_token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
        ], 200, $message);
    }

    private function createRefreshToken()
    {
        $key_token = bcrypt(env('SECRET_KEY_TOKEN'));
        $data = [
            'user_id' => Auth::user()->id,
            'key_token' => $key_token,
            'exp' => time() + config('jwt.refresh_ttl'),
        ];

        $refresh_token = JWTAuth::getJWTProvider()->encode($data);
        return $refresh_token;
    }

}