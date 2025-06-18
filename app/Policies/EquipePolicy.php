<?php

namespace App\Policies;

use App\Models\User;

class EquipePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function podeAtribuirEquipe(User $user)
    {
        return $user->role === 'tecnica';
    }
}
