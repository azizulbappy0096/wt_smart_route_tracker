<?php
require_once BASE_PATH . '/core/Model.php';

class FavoritesModel extends Model
{
    function __construct($table = 'user_favorites')
    {
        $this->table = $table;
    }

    public function toggleFavorite($userId, $trainId)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = :user_id AND train_id = :train_id";
            $params = [
                ':user_id' => $userId,
                ':train_id' => $trainId,
            ];
            $stmt = $this->query($sql, $params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['count'] > 0) {
                $this->removeFavorite($userId, $trainId);
                return $this->pass(true, 'SUCCESS', [
                    'message' => 'Favorite removed successfully.',
                ]);
            }

            $sql = "INSERT INTO {$this->table} (user_id, train_id) VALUES (:user_id, :train_id)";
            $params = [
                ':user_id' => $userId,
                ':train_id' => $trainId,
            ];
            $stmt = $this->query($sql, $params);

            return $this->pass(true, 'CREATED', ['message' => 'Favorite added successfully.']);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function removeFavorite($userId, $trainId)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE user_id = :user_id AND train_id = :train_id";
            $params = [
                ':user_id' => $userId,
                ':train_id' => $trainId,
            ];
            $stmt = $this->query($sql, $params);

            return $this->pass(true, 'SUCCESS', ['message' => 'Favorite removed successfully.']);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function getUserFavorites($userId)
    {
        try {
            $sql = "SELECT 
                    t.*, 
                    curr.name as current_station_name, curr.code as current_station_code,
                    st.name as start_station_name, st.code as start_station_code,
                    en.name as end_station_name, en.code as end_station_code
                FROM {$this->table} f
                JOIN trains t ON f.train_id = t.id
                LEFT JOIN stations curr ON t.current_station = curr.id
                LEFT JOIN stations st ON t.start_station = st.id
                LEFT JOIN stations en ON t.end_station = en.id
                WHERE f.user_id = :user_id";

            $params = [
                ':user_id' => $userId,
            ];

            $stmt = $this->query($sql, $params);
            $trains = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $routeModel = new RouteModel();
            foreach ($trains as &$train) {
                $routeResult = $routeModel->getRoutesByTrain($train['id']);
                $routes = $routeResult['data'] ?? [];
                $train['route'] = $routes;

                $train['next_station_name'] = 'N/A';
                $train['next_arrival_time'] = null;

                foreach ($routes as $index => $stop) {
                    if ($stop['station_id'] == $train['current_station']) {
                        if (isset($routes[$index + 1])) {
                            $nextStop = $routes[$index + 1];
                            $train['next_station_name'] = $nextStop['station_name'];
                            $train['next_arrival_time'] = $nextStop['arrival_time'];
                        }
                        break;
                    }
                }
            }

            return $this->pass(true, 'SUCCESS', [
                'message' => 'Favorite trains fetched.',
                'data' => $trains,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }

    public function isFavorite($userId, $trainId)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = :user_id AND train_id = :train_id";
            $params = [
                ':user_id' => $userId,
                ':train_id' => $trainId,
            ];
            $stmt = $this->query($sql, $params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->pass(true, 'SUCCESS', [
                'is_favorite' => $result['count'] > 0,
            ]);
        } catch (PDOException $e) {
            return $this->handleException($e);
        }
    }
}
