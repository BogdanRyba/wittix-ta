<?php
declare(strict_types=1);

namespace app\Repositories\Contracts;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getUserList(?string $search = null): LengthAwarePaginator;

    /**
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User;

    /**
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool;
}
