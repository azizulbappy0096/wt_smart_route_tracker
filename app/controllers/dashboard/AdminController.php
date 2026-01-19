<?php

require_once BASE_PATH . '/core/Controller.php';

class AdminController extends Controller
{
    private $model;

    function __construct($requestUri)
    {
        parent::__construct($requestUri);
    }

    public function adminPanelView()
    {
        $this->loadView('dashboard/admin/monitor.php');
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
        $this->loadView('dashboard/admin/users.php');
    }
    public function manageReportsView()
    {
        $this->loadView('dashboard/admin/reports.php');
    }
}
