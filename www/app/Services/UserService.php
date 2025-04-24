<?php

namespace App\Services;

use App\Models\User;
use App\Enums\TypesRole;

class UserService
{
    public function getFilteredUsers(array $filters, int $perPage = 10)
    {
        $query = User::query()->select(['id', 'name', 'email', 'email_verified_at', 'created_at', 'role']);

        if (!empty($filters['search_name'])) {
            $query->byName($filters['search_name']);
        }

        if (!empty($filters['search_email'])) {
            $query->byEmail($filters['search_email']);
        }

        return $query->paginate(min($perPage, 100))->withQueryString();
    }

    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'] ?? TypesRole::USER->value,
        ]);
    }

    public function updateUser(User $user, array $data): bool
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = bcrypt($data['password']);
        }

        return $user->update($updateData);
    }

    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }

    public function isLastAdmin(User $user): bool
    {
        return $user->role === TypesRole::ADMIN->value &&
            User::where('role', TypesRole::ADMIN->value)->count() <= 1;
    }
}
