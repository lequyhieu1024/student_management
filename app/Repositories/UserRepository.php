<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }
    public function show($id)
    {
        return $this->model->with('student')->findOrFail($id);
    }
    public function updateUser($data, $id)
    {
        $user = $this->model->findOrFail($id);
        return $user->update([
            'name' => $data['name'],
            'password' => $data['password'] ?? $user->password,
        ]);
    }
}
