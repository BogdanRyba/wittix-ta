<?php
declare(strict_types=1);

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use app\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getUserList(?string $search = null): LengthAwarePaginator
    {
        return $this->userRepository->getUserList($search);
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function createUser(UserDTO $userDTO): User
    {
        $data = $userDTO->toArray();
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createUser($data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepository->deleteUser($id);
    }

    public function generateUserName($firstName, $lastName): string
    {
        return strtolower($firstName . '_' . $lastName);
    }
}
