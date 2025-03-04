<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * TransactionRepository constructor.
     * @param User $model
     */
    public function __construct(protected User $model)
    {
    }

    /**
     * Get all users
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get user by id
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Create new user
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return $this->model->create($data);
    }

    /**
     * Update user by user model
     *
     * @param Model $user
     * @param array $data
     * @return bool
     */
    public function updateUser(Model $user, array $data): bool
    {
        return $user->update($data);
    }
}
