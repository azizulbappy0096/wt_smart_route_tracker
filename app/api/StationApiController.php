<?php

require_once BASE_PATH . '/core/ApiController.php';
require_once BASE_PATH . '/app/controllers/StationController.php';

class StationApiController extends ApiController
{
    private $controller;

    function __construct()
    {
        parent::__construct();
        $this->controller = new StationController($_SERVER['REQUEST_URI']);
    }

    public function getAllStations()
    {
        $result = $this->controller->getAllStations();
        $this->jsonResponse($result);
    }

    public function addStation()
    {
        $name = $this->requestBody['name'] ?? '';
        $code = $this->requestBody['code'] ?? '';
        $city = $this->requestBody['city'] ?? '';
        $state = $this->requestBody['state'] ?? '';
        $platforms = $this->requestBody['platforms'] ?? '';

        $result = $this->controller->addStation($name, $code, $city, $state, $platforms);
        $this->jsonResponse($result);
    }
    public function updateStation()
    {
        $id = $this->requestBody['id'] ?? '';
        $name = $this->requestBody['name'] ?? '';
        $code = $this->requestBody['code'] ?? '';
        $city = $this->requestBody['city'] ?? '';
        $state = $this->requestBody['state'] ?? '';
        $platforms = $this->requestBody['platforms'] ?? '';
        $result = $this->controller->updateStation($id, $name, $code, $city, $state, $platforms);
        $this->jsonResponse($result);
    }
    public function deleteStation()
    {
        $id = $_GET['id'] ?? '';
        $result = $this->controller->deleteStation($id);
        $this->jsonResponse($result);
    }
}
