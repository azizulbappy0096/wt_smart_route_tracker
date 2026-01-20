<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/TrainModel.php';
require_once BASE_PATH . '/app/models/AuthModel.php';
require_once BASE_PATH . '/app/models/ReportsModel.php';

class AdminController extends Controller
{
    private $model;

    function __construct($requestUri)
    {
        parent::__construct($requestUri);
    }

    public function adminPanelView()
    {
        $trainModel = new TrainModel();
        $result = $trainModel->analytics();
        $analytics = $result['data'] ?? [];

        $this->loadView('dashboard/admin/monitor.php', ['analytics' => $analytics]);
    }
    public function manageTrainsView()
    {
        $this->loadView('dashboard/admin/trains.php');
    }
    public function manageStationsView()
    {
        $this->loadView('dashboard/admin/stations.php');
    }
    public function manageUsersView()
    {
        $authModel = new AuthModel();
        $result = $authModel->getAllUsers();
        $users = $result['data'] ?? [];

        $this->loadView('dashboard/admin/users.php', ['users' => $users]);
    }
    public function manageReportsView()
    {
        $reportModel = new ReportsModel();
        $result = $reportModel->getAllReports();

        $stats = $reportModel->getReportStats();

        $this->loadView('dashboard/admin/reports.php', [
            'reports' => $result['data'] ?? [],
            'stats' => $stats['data'] ?? [],
        ]);
    }
}
