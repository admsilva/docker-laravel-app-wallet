<?php


namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Exception;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var WalletService
     */
    protected WalletService $walletService;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param WalletService $walletService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        WalletService $walletService
    ) {
        $this->userRepository = $userRepository;
        $this->walletService = $walletService;
    }

    /**
     * Get all users
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAllUsers();
    }

    /**
     * Get user by id
     *
     * @param int $id
     * @return Model
     * @throws Exception
     */
    public function getUserById(int $id): Model
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            throw new Exception('User not found', 404);
        }

        return $user;
    }

    /**
     * Make a new user
     *
     * @param array $user
     * @return Model
     * @throws Exception
     */
    public function makeUser(array $user): Model
    {
        DB::beginTransaction();
        $newUser = $this->userRepository->createUser($user);

        if (!$newUser) {
            DB::rollBack();
            throw new Exception('User not created', 409);
        }

        $dataWallet = [
            'user_id' => $newUser->id,
            'balance' => 0
        ];

        $wallet = $this->walletService->makeWallet($dataWallet);

        if (!$wallet) {
            DB::rollBack();
            throw new Exception('Wallet to user not created', 409);
        }

        DB::commit();
        return $newUser;
    }

    /**
     * Changed user by id
     *
     * @param int $id
     * @param array $dataUser
     * @return bool|null
     * @throws Exception
     */
    public function changeUser(int $id, array $dataUser): ?bool
    {
        DB::beginTransaction();
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            DB::rollBack();
            throw new Exception(
                'User Not Found.',
                404
            );
        }

        $isUpdated = $this->userRepository->updateUser($user, $dataUser);

        if (!$isUpdated) {
            DB::rollBack();
            throw new Exception(
                'User Not Updated.',
                409
            );
        }

        DB::commit();
        return $isUpdated;
    }

    /**
     * Delete user by id
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteUser(int $id): bool
    {
        DB::beginTransaction();
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            DB::rollBack();
            throw new Exception(
                'User not found.',
                404
            );
        }

        $balance = ($user->wallet) ? $user->wallet->balance : 0;

        if ($balance !== 0) {
            DB::rollBack();
            throw new Exception(
                'Not possible delete user because his balance not is zero!',
                409
            );
        }

        if ($user->wallet) {
            $walletId = $user->wallet->id;
            $isWalletDeleted = $this->walletService->deleteWallet($walletId);
            if (!$isWalletDeleted) {
                DB::rollBack();
                throw new Exception(
                    'User not deleted because wallet not closed!',
                    409
                );
            }
        }

        $user->status = 'deactivate';
        $userData = Arr::except(
            $user->toArray(),
            ['id', 'created_at', 'updated_at', 'wallet']
        );
        $isUserUpdated = $this->userRepository->updateUser($user, $userData);

        if (!$isUserUpdated) {
            throw new Exception(
                'User not deleted!',
                409
            );
        }

        DB::commit();
        return true;
    }
}
