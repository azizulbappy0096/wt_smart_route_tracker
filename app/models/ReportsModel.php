<?php
require_once BASE_PATH . '/core/Model.php';

class ReportsModel extends Model
{
    function __construct($table = 'reports')
    {
        $this->table = $table;
    }

    public function createReport($reported_by, $issueTrain, $category, $title, $description)
    {
        $sql = "
            INSERT INTO {$this->table} 
            (reported_by, issueTrain, category, title, description, status, priority) 
            VALUES 
            (:reported_by, :issueTrain, :category, :title, :description, :status, :priority)
        ";
        $params = [
            ':reported_by' => $reported_by,
            ':issueTrain' => $issueTrain,
            ':category' => $category,
            ':title' => $title,
            ':description' => $description,
            ':status' => 'open',
            ':priority' => 'medium',
        ];
        $stmt = $this->query($sql, $params);
        if ($stmt->rowCount() > 0) {
            $id = $this->connectDB()->lastInsertId();
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->query($sql, [':id' => $id]);
            $report = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->pass(true, 'REPORT_CREATED', [
                'data' => $report,
            ]);
        } else {
            return $this->pass(false, 'BAD_REQUEST', [
                'message' => 'Failed to create report',
            ]);
        }
    }

    public function getUserReports($userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE reported_by = :userId ORDER BY created_at DESC";
        $stmt = $this->query($sql, [':userId' => $userId]);
        $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->pass(true, 'SUCCESS', [
            'data' => $reports,
        ]);
    }
}
