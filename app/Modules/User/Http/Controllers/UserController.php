<?php

namespace App\Modules\User\Http\Controllers;

use App\Bootstrap\Http\Controllers\Controller;
use App\Modules\User\Http\Requests\UpdateProfileRequest;
use App\Modules\User\Models\User;
use App\Modules\User\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function profile(Request $request): Response
    {
        $user = $request->user();
        
        return Inertia::render('User/Profile', [
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Update the user's profile.
     */
    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $user->update($request->validated());

        return redirect()->route('user.profile')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Display the user's settings.
     */
    public function settings(Request $request): Response
    {
        $user = $request->user();
        
        return Inertia::render('User/Settings', [
            'user' => new UserResource($user),
        ]);
    }
} 