<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use app\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{

    public function getUserList(?string $search = null): LengthAwarePaginator
    {
        $query = User::query();
        if ($search) {
            $query
                ->where('username', 'like', "%{$search}%")
                ->where('first_name', 'like', "%{$search}%")
                ->where('first_name', 'like', "%{$search}%");
        }

        return $query->orderBy('id')->paginate(User::PAGINATION_COUNT);
    }

    public function getUserById(int $id): ?User
    {
        return User::query()->findOrFail($id);
    }

    public function createUser(array $data): User
    {
        return User::query()->create($data);
    }

    public function deleteUser(int $id): bool
    {
        return User::destroy($id) > 0;
    }
}
