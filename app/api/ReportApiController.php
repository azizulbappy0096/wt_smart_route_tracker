<?php

require_once BASE_PATH . '/core/ApiController.php';
require_once BASE_PATH . '/app/controllers/ReportsController.php';

class ReportApiController extends ApiController
{
    private $controller;

    public function __construct()
    {
        parent::__construct();
        $this->controller = new ReportsController($_SERVER['REQUEST_URI']);
    }

    public function removeReport()
    {
        $id = $_GET['id'] ?? '';

        $result = $this->controller->removeReport($id);
        $this->jsonResponse($result);
    }
}
