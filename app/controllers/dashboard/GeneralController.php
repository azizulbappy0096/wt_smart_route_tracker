<?php

require_once BASE_PATH . '/core/Controller.php';

class GeneralController extends Controller
{
    private $model;

    function __construct($requestUri)
    {
        parent::__construct($requestUri);
    }

    public function searchTrainsView()
    {
        $this->loadView('dashboard/general/search_trains.php');
    }
    public function trackingView()
    {
        $this->loadView('dashboard/general/tracking.php');
    }
    public function reportIssueView()
    {
        $this->loadView('dashboard/general/report_issue.php');
    }
    public function favoritesView()
    {
        $this->loadView('dashboard/general/favorites.php');
    }
    public function notificationsView()
    {
        $this->loadView('dashboard/general/notifications.php');
    }
}
