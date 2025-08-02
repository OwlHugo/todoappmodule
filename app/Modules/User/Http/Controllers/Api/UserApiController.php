<?php

namespace App\Modules\User\Http\Controllers\Api;

use App\Bootstrap\Controllers\Controller;
use App\Modules\User\Http\Requests\UpdateProfileRequest;
use App\Modules\User\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();
        
        return response()->json([
            'data' => new UserResource($user)
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        
        $user->update($request->validated());

        return response()->json([
            'message' => 'Perfil atualizado com sucesso!',
            'data' => new UserResource($user)
        ]);
    }

    public function settings(Request $request): JsonResponse
    {
        $user = $request->user();
        
        return response()->json([
            'data' => new UserResource($user)
        ]);
    }
} 