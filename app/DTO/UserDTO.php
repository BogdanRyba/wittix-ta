<?php
declare(strict_types=1);

namespace App\DTO;

class UserDTO
{
    public mixed $username;
    public mixed $password;
    public mixed $first_name;
    public mixed $last_name;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }

}
