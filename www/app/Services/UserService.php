<?php

namespace App\Services;

use App\Models\User;

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

    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
        ]);
    }

    public function updateUser(User $user, array $data)
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        return $user->update($updateData);
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }
}