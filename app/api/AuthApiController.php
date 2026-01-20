<?php

require_once BASE_PATH . '/core/ApiController.php';
require_once BASE_PATH . '/app/controllers/AuthController.php';

class AuthApiController extends ApiController
{
    private $controller;

    function __construct()
    {
        parent::__construct();
        $this->controller = new AuthController();
    }

    public function register()
    {
        $fullName = $this->requestBody['full_name'] ?? '';
        $email = $this->requestBody['email'] ?? '';
        $password = $this->requestBody['password'] ?? '';
        $userType = $this->requestBody['user_type'] ?? 'user';

        $result = $this->controller->register($fullName, $email, $password, $userType);

        $this->jsonResponse($result);
    }

    public function login()
    {
        $email = $this->requestBody['email'] ?? '';
        $password = $this->requestBody['password'] ?? '';

        $result = $this->controller->login($email, $password);

        $this->jsonResponse($result);
    }

    public function logout()
    {
        $result = $this->controller->logout();

        header('Location: /', true, 302);
        exit();
    }
}
