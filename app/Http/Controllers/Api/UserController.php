<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\DeleteUserJob;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(private readonly UserService $userService)
    {
        $test = 'test';
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function userList(Request $request)
    {
        $users = $this->userService->getUserList($request->input('search'));

        return UserResource::collection($users);
    }

    public function destroy(DeleteUserRequest $request, int $id)
    {
        DeleteUserJob::dispatch($id);
    }

}
