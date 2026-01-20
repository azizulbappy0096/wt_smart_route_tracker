<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/controllers/TrainController.php';
require_once BASE_PATH . '/app/controllers/FavoritesController.php';
require_once BASE_PATH . '/app/controllers/ReportsController.php';

class GeneralController extends Controller
{
    private $trainController;

    function __construct($requestUri)
    {
        parent::__construct($requestUri);
        $this->trainController = new TrainController($requestUri);
    }

    public function searchTrainsView()
    {
        $query = trim($_GET['query'] ?? '') ?: null;
        $station = ($_GET['station'] ?? 'all') === 'all' ? null : $_GET['station'];
        $type = ($_GET['type'] ?? 'all') === 'all' ? null : $_GET['type'];

        $result = $this->trainController->searchTrains($query, $station, $type);
        $trains = $result['data'] ?? [];

        $favoritesController = new FavoritesController($_SERVER['REQUEST_URI']);
        foreach ($trains as $index => $train) {
            $trains[$index]['is_favorite'] = $favoritesController->isFavorite(
                $_SESSION['user']['id'],
                $train['id'],
            );
        }

        $this->loadView('dashboard/general/search_trains.php', [
            'trains' => $trains,
            'searchParams' => ['query' => $query, 'station' => $station, 'type' => $type],
        ]);
    }
    public function trackingView()
    {
        $trainId = $_GET['train_id'] ?? null;
        $allTrainsResult = $this->trainController->getAllTrains();
        $allTrains = $allTrainsResult['data'] ?? [];

        if (!$trainId) {
            $trainId = $allTrains[0]['id'] ?? null;
        }

        $result = $this->trainController->getTrainById($trainId);
        $train = $result['data'] ?? null;

        if (!$train) {
            header('Location: /dashboard');
            exit();
        }

        $this->loadView('dashboard/general/tracking.php', [
            'train' => $train,
            'allTrains' => $allTrains,
        ]);
    }
    public function reportIssueView()
    {
        $reportsController = new ReportsController($_SERVER['REQUEST_URI']);
        $result = $reportsController->getUserReports($_SESSION['user']['id']);

        $allTrainsResult = $this->trainController->getAllTrains();
        $allTrains = $allTrainsResult['data'] ?? [];

        $this->loadView('dashboard/general/report_issue.php', [
            'reports' => $result['data'] ?? [],
            'trains' => $allTrains,
        ]);
    }
    public function favoritesView()
    {
        $favoritesController = new FavoritesController($_SERVER['REQUEST_URI']);
        $result = $favoritesController->getUserFavorites($_SESSION['user']['id']);
        $favorites = $result['data'] ?? [];

        $this->loadView('dashboard/general/favorites.php', ['trains' => $favorites]);
    }
    public function notificationsView()
    {
        $this->loadView('dashboard/general/notifications.php');
    }
}
