<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteUserJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    private UserService $userService;

    /**
     * Create a new job instance.
     * @param int $userId
     */
    public function __construct(protected int $userId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->userService->deleteUser($this->userId);
    }
}
