<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\UserDTO;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AddUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user by entering first name and last name';

    public function __construct(private readonly UserService $userService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstName = $this->ask('First name');
        $lastName = $this->ask('Last name');

        $validator = Validator::make(
            ['first_name' => $firstName, 'last_name' => $lastName],
            ['first_name' => 'required|string|max:255', 'last_name' => 'required|string|max:255']
        );

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $userName = $this->userService->generateUserName($firstName, $lastName);
        $tmpPassword = Str::random(8);

        $userDTO = new UserDTO([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $userName,
            'password' => $tmpPassword,
        ]);

        $this->userService->createUser($userDTO);

        $this->info('User created successfully');
        $this->info('Username: ' . $userName);
        $this->info('Password: ' . $tmpPassword);

        return 0;
    }
}
