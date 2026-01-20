<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/AuthModel.php';

class AuthController extends Controller
{
    private $model;

    function __construct()
    {
        $this->model = new AuthModel();
    }

    // views
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

    public function getAllUsers()
    {
        $result = $this->model->getAllUsers();

        return $result;
    }

    // actions
    public function register($fullName, $email, $password, $userType = 'user')
    {
        $errors = [];

        if (empty($fullName)) {
            $errors['full_name'] = 'Full name required';
        }
        if (empty($email)) {
            $errors['email'] = 'Email required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email';
        }

        if (empty($password)) {
            $errors['password'] = 'Password required';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Password must be 6+ characters';
        }

        if (!empty($errors)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Validation failed',
                'errors' => $errors,
            ]);
        }

        return $this->model->register($fullName, $email, $password, $userType);
    }

    public function login($email, $password)
    {
        $errors = [];
        if (empty($email)) {
            $errors['email'] = 'Email required';
        }
        if (empty($password)) {
            $errors['password'] = 'Password required';
        }
        if (!empty($errors)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Validation failed',
                'errors' => $errors,
            ]);
        }

        $result = $this->model->login($email, $password);

        if ($result['success']) {
            $user_id = $result['data']['id'];

            $token = base64_encode($user_id);
            setcookie(CONSTANTS['session_cookie'], $token, [
                'expires' => time() + 1 * 24 * 60 * 60,
                'path' => '/',
                'httponly' => true,
                'secure' => false,
                'samesite' => 'Lax',
            ]);
        }

        return $result;
    }

    public function logout()
    {
        session_destroy();
        session_unset();

        setcookie(CONSTANTS['session_cookie'], '', time() - 3600, '/');

        return $this->pass(true, 'SUCCESS', [
            'message' => 'Logged out successfully.',
        ]);
    }

    public function changePassword($userId, $currentPassword, $newPassword)
    {
        if (empty($userId)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Invalid user ID',
            ]);
        }
        return $this->model->changePassword($userId, $currentPassword, $newPassword);
    }

    public function getById($id)
    {
        if (empty($id)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Invalid user ID',
            ]);
        }
        return $this->model->getById($id);
    }

    public function updateProfile($id, $fullName, $email, $phone)
    {
        if (empty($id)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Invalid user ID',
            ]);
        }
        return $this->model->updateProfile($id, $fullName, $email, $phone);
    }

    public function updateProfilePicture($id, $fileTmpPath, $fileName, $fileSize, $fileType)
    {
        if (empty($id)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Invalid user ID',
            ]);
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            return $this->pass(false, 'INVALID_FILE_TYPE', [
                'message' => 'Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.',
                'errors' => [
                    'profile_picture' => 'Invalid file type.',
                ],
            ]);
        }
        if ($fileSize > 2 * 1024 * 1024) {
            return $this->pass(false, 'FILE_TOO_LARGE', [
                'message' => 'File size exceeds 2MB limit.',
                'errors' => [
                    'profile_picture' => 'File size exceeds limit.',
                ],
            ]);
        }
        $uploadDir = BASE_PATH . '/assets/uploads/';
        $newFileName = 'profile_picture_' . time() . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            return $this->pass(false, 'UPLOAD_FAILED', [
                'message' => 'Failed to upload profile picture.',
                'errors' => [
                    'profile_picture' => 'Upload failed.',
                ],
            ]);
        }

        $result = $this->model->updateProfilePicture($id, '/assets/uploads/' . $newFileName);
        $result['data'] = [
            'profile_picture' => '/assets/uploads/' . $newFileName,
        ];
        return $result;
    }
}
