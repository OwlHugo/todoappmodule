<?php

namespace App\Modules\User\Repositories;

use App\Bootstrap\Repositories\BaseRepository;
use App\Modules\User\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Find user by email.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Find user by ID with tasks.
     */
    public function findWithTasks(int $id): ?User
    {
        return User::with('tasks')->find($id);
    }
} 