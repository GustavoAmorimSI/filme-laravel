<?php

namespace App\Policies;

use App\Models\Exercise;
use App\Models\User;

class ExercisePolicy
{
    public function view(User $user, Exercise $exercise)
    {
        return $user->id === $exercise->user_id;
    }

    public function create(User $user)
    {
        return true; // Qualquer usuário autenticado pode criar
    }

    public function update(User $user, Exercise $exercise)
    {
        return $user->id === $exercise->user_id;
    }

    public function delete(User $user, Exercise $exercise)
    {
        return $user->id === $exercise->user_id;
    }
}