<?php

namespace App\Policies;

use App\Models\User;

class FunctionalSynthesisPolicy
{
    /**
     * Vérifie si le profil connecté peut accéder
     * à l'espace des synthèses.
     */
    public function viewAny(User $actor): bool
    {
        return $this->isAuthorizedProfessional($actor);
    }

    /**
     * Vérifie si le profil connecté peut consulter
     * la synthèse de l'utilisateur cible.
     */
    public function view(User $actor, User $target): bool
    {
        if (!$this->isAuthorizedProfessional($actor)) {
            return false;
        }

        if (!$this->isValidTarget($target)) {
            return false;
        }

        // L'administrateur peut consulter tous les profils.
        if ($actor->role === 'admin') {
            return true;
        }

        // La micronutritionniste peut consulter
        // tous les profils sauf les administrateurs.
        if ($actor->role === 'micronutritionniste') {
            return $target->role !== 'admin';
        }

        return false;
    }

    /**
     * Vérifie si le profil connecté peut générer
     * la synthèse de l'utilisateur cible.
     */
    public function generate(User $actor, User $target): bool
    {
        return $this->view($actor, $target);
    }

    /**
     * Vérifie le profil connecté.
     */
    private function isAuthorizedProfessional(User $actor): bool
    {
        return $actor->is_active
            && !$actor->is_deleted
            && in_array($actor->role, [
                'admin',
                'micronutritionniste',
            ], true);
    }

    /**
     * Vérifie le profil cible.
     */
    private function isValidTarget(User $target): bool
    {
        return $target->is_active
            && !$target->is_deleted
            && in_array($target->role, [
                'admin',
                'micronutritionniste',
                'client',
            ], true);
    }
}