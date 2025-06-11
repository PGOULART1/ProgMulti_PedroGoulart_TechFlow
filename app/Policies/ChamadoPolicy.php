<?php

namespace App\Policies;

use App\Models\Chamado;
use App\Models\User; // Importe o modelo User

class ChamadoPolicy
{
    /**
     * Determine whether the user can update the priority and status of the chamado.
     */
    public function updatePriorityAndStatus(User $user, Chamado $chamado): bool
    {
        // O usuário autenticado ($user) é técnico?
        // E o chamado está sendo atualizado?
        return $user->role === 'tecnica';
    }

    /**
     * Determine whether the user can view the model. (Optional, já fizemos no controller)
     */
    public function view(User $user, Chamado $chamado): bool
    {
        // O próprio usuário pode ver o chamado dele OU o usuário é técnico.
        return $user->id === $chamado->user_id || $user->role === 'tecnica';
    }

    /**
     * Determine whether the user can update the model (titulo e descrição).
     */
    public function update(User $user, Chamado $chamado): bool
    {
        // Apenas o proprietário do chamado ou um usuário técnico pode atualizar
        return $user->id === $chamado->user_id || $user->role === 'tecnica';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Chamado $chamado): bool
    {
        // Apenas o proprietário do chamado ou um usuário técnico pode excluir
        return $user->id === $chamado->user_id || $user->role === 'tecnica';
    }
}