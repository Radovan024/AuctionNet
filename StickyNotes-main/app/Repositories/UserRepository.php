<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function register(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function login(string $email)
    {
        return User::firstWhere('email', $email);
    }

    public function getUser(string $email)
    {
        $user = User::firstWhere('email', $email);
        return $user->id;
    }

    public function updateUser($userId, array $data)
    {
        return User::where('id', $userId)->update([
            'email' => $data['newEmail'],
            'name' => $data['name'],
        ]);
    }
}
