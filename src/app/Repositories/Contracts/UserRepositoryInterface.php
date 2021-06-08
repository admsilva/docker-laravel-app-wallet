<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface UserRepositoryInterface
 * @package App\Repositories\Contracts
 */
interface UserRepositoryInterface
{
    /**
     * Get all users
     *
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * Get user by id
     *
     * @param int $id
     * @return Model|null
     */
    public function getUserById(int $id): ?Model;

    /**
     * Create new user
     *
     * @param array $data
     * @return Model
     */
    public function createUser(array $data): Model;

    /**
     * Update user by user model
     *
     * @param Model $user
     * @param array $data
     * @return bool
     */
    public function updateUser(Model $user, array $data): bool;
}
