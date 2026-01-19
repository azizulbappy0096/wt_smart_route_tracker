<?php

class Model
{
    protected $table;

    function __construct() {}

    protected function connectDB()
    {
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $exception) {
            error_log('DB Connection Error: ' . $exception->getMessage());
            echo 'Database connection error.';
            exit();
        }
    }

    public static function init()
    {
        $pdo = (new self())->connectDB();
        $statements = [
            // Users table
            "
                CREATE TABLE IF NOT EXISTS users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                full_name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                phone VARCHAR(20),
                profile_picture VARCHAR(255),
                user_type ENUM('admin', 'user') NOT NULL DEFAULT 'user',
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP );
            ",
        ];

        foreach ($statements as $smt) {
            $pdo->exec($smt);
        }
    }

    protected function handleException(PDOException $e)
    {
        return [
            'success' => false,
            'status' => 'SERVER_ERROR',
            'message' => 'Internal server error',
        ];
    }

    protected function query($sql, $params = [])
    {
        $pdo = $this->connectDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    protected function pass($success, $status, $arg = [])
    {
        return [
            'success' => $success,
            'status' => $status,
            ...$arg,
        ];
    }
}
