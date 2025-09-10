<?php

namespace App\Controller;

class UserController   
{
    public function render(): void 
    {
        if($_POST) {
            $user = new UserController(
                name: $_POST ['user_name'],
                email: $_POST ['user_email'],
                password: $_POST['user_password']
            );
        }
    }
}

?>