<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequestUpdate;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse; 
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:api', ['except' => ['profile']]);
      $this->middleware('jwt.verify', ['only' => ['profile']]);
      $this->middleware('api');
    }

    public function profile(): JsonResponse
    {
        return jsonResponse(JWTAuth::user());
    }

    /**
     * Cập nhật category theo id trong database
     *
     * @param UserRequestUpdate $request
     * @param User              $user
     *
     * @return JsonResponse
     */
    public function update(UserRequestUpdate $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = User::findOrFail($id);

            if (isset($data['password'])) {
                $hashedPassword = Hash::make($data['password']);
            } else {
                $hashedPassword = $user->password;
            }

            $user->update([
                'name' => $data['name'] ?? $user->name,
                'email' => $data['email'] ?? $user->email,
                'phone' => $data['phone'] ?? $user->phone,
                'password' => $hashedPassword,
            ]);

            return jsonResponse($user, 200, 'User updated successfully');
        } catch (Exception $e) {
            return jsonResponse($e->getMessage(), 403, 'Something went wrong');
        }
    }
}