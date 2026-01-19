<?php

require_once BASE_PATH . '/app/controllers/AuthController.php';

class SessionMiddleware
{
    public static function init()
    {
        session_start();
        $sessionCookie = CONSTANTS['session_cookie'];

        if (!isset($_COOKIE[$sessionCookie])) {
            return;
        }

        if (isset($_SESSION['user']) && $_SESSION['is_logged_in']) {
            return;
        }

        try {
            $token = base64_decode($_COOKIE[$sessionCookie], true);
            $user_id = $token[0];

            $model = new AuthController();
            $user = $model->getById($user_id);

            $_SESSION['user'] = [
                'id' => $user['data']['id'],
                'full_name' => $user['data']['full_name'],
                'email' => $user['data']['email'],
                'phone' => $user['data']['phone'] ?? '',
                'profile_picture' => $user['data']['profile_picture'] ?? '',
                'user_type' => $user['data']['user_type'],
            ];
            $_SESSION['is_logged_in'] = true;

            session_regenerate_id(true);
        } catch (Exception $e) {
            error_log('Session error: ' . $e->getMessage());
        }
    }

    public static function getCurrentUser()
    {
        if (!isset($_SESSION['user']) || !$_SESSION['is_logged_in']) {
            return null;
        }

        return [
            'id' => $_SESSION['user']['id'] ?? 0,
            'full_name' => $_SESSION['user']['full_name'] ?? '',
            'email' => $_SESSION['user']['email'] ?? '',
            'phone' => $_SESSION['user']['phone'] ?? '',
            'profile_picture' => $_SESSION['user']['profile_picture'] ?? '',
            'user_type' => $_SESSION['user']['user_type'] ?? 'user',
            'is_logged_in' => $_SESSION['is_logged_in'] ?? false,
        ];
    }
}
