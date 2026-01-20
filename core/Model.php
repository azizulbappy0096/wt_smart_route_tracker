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
            'SET FOREIGN_KEY_CHECKS = 0;',
            // Users
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
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
                );",

            // Stations
            "
                CREATE TABLE IF NOT EXISTS stations (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                code VARCHAR(10) NOT NULL,
                city VARCHAR(100) NOT NULL,
                state VARCHAR(100) NOT NULL,
                platforms INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );",
            // trains
            "
                CREATE TABLE IF NOT EXISTS trains (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            number VARCHAR(20) NOT NULL,
            name VARCHAR(255) NOT NULL,
            type ENUM('Express', 'Local', 'Super Fast', 'Passenger') NOT NULL,
            status ENUM('on-time', 'delayed', 'stopped', 'cancelled') DEFAULT 'on-time',
            current_station INT UNSIGNED default NULL,
            speed INT DEFAULT 0,
            start_station INT UNSIGNED default NULL,
            end_station INT UNSIGNED default NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (current_station) REFERENCES stations(id) ON DELETE SET NULL,
            FOREIGN KEY (start_station) REFERENCES stations(id) ON DELETE SET NULL,
            FOREIGN KEY (end_station) REFERENCES stations(id) ON DELETE SET NULL
        );",
            // routes
            "
        CREATE TABLE IF NOT EXISTS routes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            train_id INT UNSIGNED NOT NULL,
            station_id INT UNSIGNED NOT NULL,
            arrival_time TIMESTAMP NULL DEFAULT NULL,  
            departure_time TIMESTAMP NULL DEFAULT NULL,
            platform INT,
            distance INT,
            stop_order INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (train_id) REFERENCES trains(id) ON DELETE CASCADE,
            FOREIGN KEY (station_id) REFERENCES stations(id) ON DELETE CASCADE
        );",
            // alerts
            "
CREATE TABLE IF NOT EXISTS alerts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    train_id INT UNSIGNED NOT NULL,
    type ENUM('delay', 'schedule-change', 'cancellation', 'maintenance') NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (train_id) REFERENCES trains(id) ON DELETE CASCADE
);",
            // reports
            "
CREATE TABLE IF NOT EXISTS reports (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reported_by INT UNSIGNED NOT NULL,
    issueTrain INT UNSIGNED DEFAULT NULL,
    category ENUM('delay', 'cancellation', 'technical', 'safety', 'other') NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('open', 'in-progress', 'resolved', 'closed') NOT NULL DEFAULT 'open',
    priority ENUM('low', 'medium', 'high', 'critical') NOT NULL DEFAULT 'medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    FOREIGN KEY (reported_by) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (issueTrain) REFERENCES trains(id) ON DELETE SET NULL
);",
            // favorites
            "
CREATE TABLE IF NOT EXISTS user_favorites (
    user_id INT UNSIGNED NOT NULL,
    train_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, train_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (train_id) REFERENCES trains(id) ON DELETE CASCADE
);",
            'SET FOREIGN_KEY_CHECKS = 1;',
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
            'error' => $e->getMessage(),
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
