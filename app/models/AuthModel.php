<?php
require_once BASE_PATH . '/core/Model.php';

class AuthModel extends Model
{
    function __construct($table = 'users')
    {
        $this->table = $table;
    }

    public function register($fullName, $email, $password, $userType = 'user')
    {
        try {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO {$this->table} (full_name, email, password, user_type)
                VALUES (:full_name, :email, :password, :user_type)";
            $params = [
                ':full_name' => $fullName,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':user_type' => $userType,
            ];
            $stmt = $this->query($sql, $params);

            return $this->pass(true, 'CREATED', ['message' => 'User registered successfully.']);
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return $this->pass(false, 'CONFLICT', [
                    'message' => 'Email already exists.',
                    'errors' => [
                        'email' => ['Email already exists.'],
                    ],
                ]);
            }

            return $this->handleException($e);
        }
    }

    public function login($email, $password)
    {
        try {
            $sql = "SELECT id, full_name, email, password, user_type 
                FROM {$this->table} WHERE email = :email LIMIT 1";
            $params = [
                ':email' => $email,
            ];
            $user = $this->query($sql, $params);
            $user = $user->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['password'])) {
                return $this->pass(false, 'UNAUTHORIZED', [
                    'message' => 'Invalid credentials.',
                ]);
            }

            unset($user['password']);

            return $this->pass(true, 'LOGIN_SUCCESS', [
                'message' => 'Login successful.',
                'data' => $user,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function getById($id)
    {
        try {
            $sql = "SELECT id, full_name, email, user_type 
                FROM {$this->table} WHERE id = :id LIMIT 1";
            $params = [
                ':id' => $id,
            ];
            $stmt = $this->query($sql, $params);

            if ($stmt->rowCount() === 0) {
                return $this->pass(false, 'NOT_FOUND', [
                    'message' => 'User not found.',
                    'data' => null,
                ]);
            }

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->pass(true, 'SUCCESS', [
                'message' => 'User retrieved successfully.',
                'data' => $user,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }
}
