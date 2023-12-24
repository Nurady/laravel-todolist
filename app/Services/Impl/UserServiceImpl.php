<?php 
    namespace App\Services\Impl;

    use App\Services\UserService;

    class UserServiceImpl implements UserService
    {
        private array $users = [
            "adis" => "rahasia"
        ];

        function login(string $user, string $password): bool
        {
            if(!isset($this->users[$user])) {
                return false;
            }

            $getPassword = $this->users[$user];
            return $password == $getPassword;

            // if($password == $getPassword) {
            //     return true;
            // } else {
            //     return false;
            // }
        }
    }
?>