<?php

require_once BASE_PATH . '/core/Model.php';

class RouteModel extends Model
{
    function __construct($table = 'routes')
    {
        $this->table = $table;
    }

    public function addRoute(
        $trainId,
        $stationId,
        $distance,
        $platform,
        $stop_order,
        $arrivalTime,
        $departureTime,
    ) {
        try {
            $sql = "INSERT INTO {$this->table} (train_id, station_id, distance, platform, stop_order, departure_time, arrival_time)
                VALUES (:train_id, :station_id, :distance, :platform, :stop_order, :departure_time, :arrival_time)";
            $params = [
                ':train_id' => $trainId,
                ':station_id' => $stationId,
                ':distance' => $distance,
                ':platform' => $platform,
                ':stop_order' => $stop_order,
                ':departure_time' => $departureTime,
                ':arrival_time' => $arrivalTime,
            ];
            $stmt = $this->query($sql, $params);

            return $this->pass(true, 'CREATED', ['message' => 'Route added successfully.']);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function updateRoute($trainId, $routes)
    {
        try {
            $deleteSql = "DELETE FROM {$this->table} WHERE train_id = :train_id";
            $deleteParams = [
                ':train_id' => $trainId,
            ];
            $this->query($deleteSql, $deleteParams);

            foreach ($routes as $route) {
                $this->addRoute(
                    $trainId,
                    $route['stationId'],
                    $route['distance'],
                    $route['platform'],
                    array_search($route, $routes) + 1,
                    $route['departureTime'],
                    $route['arrivalTime'],
                );
            }

            return $this->pass(true, 'UPDATED', ['message' => 'Routes updated successfully.']);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function getRoutesByTrain($trainId)
    {
        try {
            $sql = "SELECT 
                    r.*, 
                    s.name as station_name, 
                    s.code as station_code, 
                    s.city as station_city
                FROM {$this->table} r
                JOIN stations s ON r.station_id = s.id
                WHERE r.train_id = :train_id
                ORDER BY r.stop_order ASC";

            $params = [
                ':train_id' => $trainId,
            ];

            $stmt = $this->query($sql, $params);
            $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($routes)) {
                $routes[0]['is_start'] = true;
                $routes[count($routes) - 1]['is_end'] = true;
            }

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Routes fetched successfully.',
                'data' => $routes,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }
}
