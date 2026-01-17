<?php

require BASE_PATH . '/core/Controller.php';

class AuthController extends Controller
{
    private $model;

    function __construct() {}

    public function loginView()
    {
        $this->loadView('login.php');
    }

    public function registerView()
    {
        $this->loadView('register.php');
    }

    public function forgotPasswordView()
    {
        $this->loadView('forgot_password.php');
    }
}
