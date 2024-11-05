<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use app\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{

    public function getUserList(?string $search = null): LengthAwarePaginator
    {
        $query = User::query();

        // Always exclude the current user
        $query->where('id', '!=', Auth::id());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('username', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%");
            });
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
