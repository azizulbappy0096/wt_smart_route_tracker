<?php
/**
 *  define routes with its controllers and actions
 */
const routes = [
    '/' => ['HomeController', 'index'],
    '/home' => ['HomeController', 'index'],
    '/login' => ['AuthController', 'loginView'],
    '/register' => ['AuthController', 'registerView'],
    '/forgot-password' => ['AuthController', 'forgotPasswordView'],
];
