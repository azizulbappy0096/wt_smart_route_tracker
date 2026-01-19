<?php

require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/app/models/RouteModel.php';

class TrainModel extends Model
{
    function __construct($table = 'trains')
    {
        $this->table = $table;
    }

    public function analytics()
    {
        try {
            $trainSql = "SELECT t.name, t.number, t.type, s.name AS current_location, t.speed, t.status FROM trains t LEFT JOIN stations s ON t.current_station = s.id
    WHERE t.status != 'cancelled'
            ORDER BY t.created_at DESC;";
            $trainStmt = $this->query($trainSql);
            $trains = $trainStmt->fetchAll(PDO::FETCH_ASSOC);

            $trainStats = "SELECT 
    COUNT(CASE WHEN status != 'cancelled' THEN 1 END) AS active_trains,
    COUNT(CASE WHEN status = 'delayed' THEN 1 END) AS delayed_trains,
    ROUND(AVG(speed), 0) AS avg_speed
FROM trains;";
            $statsStmt = $this->query($trainStats);
            $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Train analytics fetched successfully.',
                'data' => [
                    'trains' => $trains,
                    'stats' => $stats,
                ],
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function addTrain($name, $number, $type, $speed, $start_station, $end_station, $route)
    {
        try {
            $pdo = $this->connectDB();
            $sql = "INSERT INTO {$this->table} (name, number, type, speed, current_station, start_station, end_station) 
                    VALUES (:name, :number, :type, :speed, :current_station, :start_station, :end_station)";
            $params = [
                ':name' => $name,
                ':number' => $number,
                ':type' => $type,
                ':speed' => $speed,
                ':current_station' => $start_station,
                ':start_station' => $start_station,
                ':end_station' => $end_station,
            ];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $id = $pdo->lastInsertId();

            $routeModel = new RouteModel();
            foreach ($route as $routeEntry) {
                $routeModel->addRoute(
                    $id,
                    $routeEntry['stationId'],
                    $routeEntry['distance'],
                    $routeEntry['platform'],
                    array_search($routeEntry, $route) + 1,
                    $routeEntry['departureTime'],
                    $routeEntry['arrivalTime'],
                );
            }

            $train = $this->getTrainById($id)['data'];

            return $this->pass(true, 'CREATED', [
                'message' => 'Train added successfully.',
                'data' => $train,
            ]);
        } catch (PDOException $e) {
            error_log('PDOException in addTrain: ' . $e->getMessage());
            return $this->handleException($e);
        }
    }

    public function getAllTrains()
    {
        $sql = 'SELECT 
                    t.*, 
                    curr.name as current_station_name, curr.code as current_station_code,
                    st.name as start_station_name, st.code as start_station_code,
                    en.name as end_station_name, en.code as end_station_code
                FROM trains t
                LEFT JOIN stations curr ON t.current_station = curr.id
                LEFT JOIN stations st ON t.start_station = st.id
                LEFT JOIN stations en ON t.end_station = en.id
                ORDER BY t.created_at DESC';
        $stmt = $this->query($sql);

        $trains = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $routeModel = new RouteModel();
        foreach ($trains as &$train) {
            $routeResult = $routeModel->getRoutesByTrain($train['id']);
            $train['route'] = $routeResult['data'] ?? [];
        }

        return $this->pass(true, 'SUCCESS', [
            'message' => 'Trains fetched successfully.',
            'data' => $trains,
        ]);
    }

    public function getTrainById($trainId)
    {
        try {
            // We join the stations table three times using aliases: curr, start, and end
            $sql = "SELECT 
                    t.*, 
                    curr.name as current_station_name, curr.code as current_station_code,
                    st.name as start_station_name, st.code as start_station_code,
                    en.name as end_station_name, en.code as end_station_code
                FROM trains t
                LEFT JOIN stations curr ON t.current_station = curr.id
                LEFT JOIN stations st ON t.start_station = st.id
                LEFT JOIN stations en ON t.end_station = en.id
                WHERE t.id = :id";

            $stmt = $this->query($sql, [':id' => $trainId]);
            $train = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$train) {
                return $this->pass(false, 'NOT_FOUND', ['message' => 'Train not found.']);
            }

            $routeModel = new RouteModel();
            $routeResult = $routeModel->getRoutesByTrain($trainId);
            $train['route'] = $routeResult['data'] ?? [];

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Train fetched successfully.',
                'data' => $train,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function updateTrain(
        $id,
        $name,
        $number,
        $type,
        $speed,
        $start_station,
        $end_station,
        $route,
    ) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET name = :name, number = :number, type = :type, speed = :speed, current_station = :current_station,
                        start_station = :start_station, end_station = :end_station
                    WHERE id = :id";
            $params = [
                ':id' => $id,
                ':name' => $name,
                ':number' => $number,
                ':type' => $type,
                ':speed' => $speed,
                ':current_station' => $start_station,
                ':start_station' => $start_station,
                ':end_station' => $end_station,
            ];
            $stmt = $this->query($sql, $params);
            $routeModel = new RouteModel();
            $routeModel->updateRoute($id, $route);
            $train = $this->getTrainById($id);

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Train updated successfully.',
                'data' => $train,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function deleteTrain($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $params = [':id' => $id];
            $stmt = $this->query($sql, $params);

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Train deleted successfully.',
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function updateTrainStatus($id, $status)
    {
        try {
            $sql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
            $params = [
                ':id' => $id,
                ':status' => $status,
            ];
            $stmt = $this->query($sql, $params);

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Train status updated successfully.',
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }
}
