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

    public function getReportStats()
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as open,
                    COUNT(CASE WHEN status = 'in-progress' THEN 1 END) as in_progress,
                    COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved
                FROM {$this->table}";

            $stmt = $this->query($sql);
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->pass(true, 'SUCCESS', [
                'data' => [
                    'total' => (int) ($stats['total'] ?? 0),
                    'open' => (int) ($stats['open'] ?? 0),
                    'in_progress' => (int) ($stats['in_progress'] ?? 0),
                    'resolved' => (int) ($stats['resolved'] ?? 0),
                ],
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function getAllReports()
    {
        try {
            $sql = "SELECT 
    r.*, 
    u.full_name as reporter_name, 
    u.email as reporter_email
FROM reports r
LEFT JOIN users u ON r.reported_by = u.id
ORDER BY r.created_at DESC";

            $stmt = $this->query($sql);
            $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Reports fetched successfully.',
                'data' => $reports,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function removeReport($reportId)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $params = [
                ':id' => $reportId,
            ];
            $stmt = $this->query($sql, $params);

            if ($stmt->rowCount() === 0) {
                return $this->pass(false, 'NOT_FOUND', [
                    'message' => 'Report not found.',
                ]);
            }

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Report deleted successfully.',
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }
}
