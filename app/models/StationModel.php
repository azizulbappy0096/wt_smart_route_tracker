<?php

require_once BASE_PATH . '/core/Model.php';

class StationModel extends Model
{
    function __construct($table = 'stations')
    {
        $this->table = $table;
    }

    public function addStation($name, $code, $city, $state, $platforms)
    {
        try {
            $pdo = $this->connectDB();
            $sql = "INSERT INTO {$this->table} (name, code, city, state, platforms)
                    VALUES (:name, :code, :city, :state, :platforms)";
            $params = [
                ':name' => $name,
                ':code' => $code,
                ':city' => $city,
                ':state' => $state,
                ':platforms' => $platforms,
            ];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $id = $pdo->lastInsertId();

            $station = $this->getStationById($id)['data'];

            return $this->pass(true, 'CREATED', [
                'message' => 'Station added successfully.',
                'data' => $station,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function getAllStations()
    {
        try {
            $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
            $stmt = $this->query($sql);
            $stations = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Stations fetched successfully.',
                'data' => $stations,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function getStationById($id)
    {
        try {
            $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
            $params = [':id' => $id];
            $stmt = $this->query($sql, $params);
            $station = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($station) {
                return $this->pass(true, 'SUCCESS', [
                    'message' => 'Station found.',
                    'data' => $station,
                ]);
            }

            return $this->pass(false, 'NOT_FOUND', [
                'message' => 'Station not found.',
                'error' => ['id' => 'not_found'],
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function updateStation($id, $name, $code, $city, $state, $platforms)
    {
        try {
            $sql = "UPDATE {$this->table} SET name = :name, code = :code, city = :city, 
                    state = :state, platforms = :platforms
                    WHERE id = :id";
            $params = [
                ':id' => $id,
                ':name' => $name,
                ':code' => $code,
                ':city' => $city,
                ':state' => $state,
                ':platforms' => $platforms,
            ];
            $stmt = $this->query($sql, $params);

            if ($stmt->rowCount() > 0) {
                return $this->pass(true, 'SUCCESS', [
                    'message' => 'Station updated successfully.',
                ]);
            }

            return $this->pass(false, 'NOT_FOUND', [
                'message' => 'Station not found.',
                'error' => ['id' => 'not_found'],
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function deleteStation($id)
    {
        try {
            $sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            $params = [':id' => $id];
            $stmt = $this->query($sql, $params);

            if ($stmt->rowCount() > 0) {
                return $this->pass(true, 'DELETED', [
                    'message' => 'Station deleted successfully.',
                ]);
            }

            return $this->pass(false, 'NOT_FOUND', [
                'message' => 'Station not found.',
                'error' => ['id' => 'not_found'],
            ]);
        } catch (PDOException $e) {
            error_log('PDOException in deleteStation: ' . $e->getMessage());
            return $this->handleException($e);
        }
    }

    public function searchStations($query)
    {
        try {
            $sql =
                'SELECT * FROM ' .
                $this->table .
                ' 
                    WHERE name LIKE :query OR code LIKE :query OR city LIKE :query 
                    ORDER BY name ASC';
            $params = [':query' => "%$query%"];
            $stmt = $this->query($sql, $params);
            $stations = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Stations found.',
                'data' => $stations,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }
}
