<?php

require_once BASE_PATH . '/core/ApiController.php';
require_once BASE_PATH . '/app/controllers/TrainController.php';

class TrainApiController extends ApiController
{
    private $controller;

    public function __construct()
    {
        parent::__construct();
        $this->controller = new TrainController($_SERVER['REQUEST_URI']);
    }

    public function addTrain()
    {
        $name = $this->requestBody['name'] ?? '';
        $number = $this->requestBody['number'] ?? '';
        $type = $this->requestBody['type'] ?? '';
        $start_station = $this->requestBody['start_station'] ?? '';
        $end_station = $this->requestBody['end_station'] ?? '';
        $speed = $this->requestBody['speed'] ?? '';
        $route = $this->requestBody['route'] ?? [];

        $result = $this->controller->addTrain(
            $name,
            $number,
            $type,
            $speed,
            $start_station,
            $end_station,
            $route,
        );
        $this->jsonResponse($result);
    }

    public function updateTrain()
    {
        $id = $this->requestBody['id'] ?? '';
        $name = $this->requestBody['name'] ?? '';
        $number = $this->requestBody['number'] ?? '';
        $type = $this->requestBody['type'] ?? '';
        $start_station = $this->requestBody['start_station'] ?? '';
        $end_station = $this->requestBody['end_station'] ?? '';
        $speed = $this->requestBody['speed'] ?? '';
        $route = $this->requestBody['route'] ?? [];

        $result = $this->controller->updateTrain(
            $id,
            $name,
            $number,
            $type,
            $speed,
            $start_station,
            $end_station,
            $route,
        );
        $this->jsonResponse($result);
    }

    public function deleteTrain()
    {
        $id = $_GET['id'] ?? '';

        if (empty($id) || !is_numeric($id)) {
            $this->jsonResponse([
                'success' => false,
                'code' => 'VALIDATION_FAILED',
                'data' => [
                    'message' => 'Valid train ID is required.',
                ],
            ]);
            return;
        }

        $result = $this->controller->deleteTrain($id);
        $this->jsonResponse($result);
    }

    public function updateTrainStatus()
    {
        $id = $this->requestBody['id'] ?? '';
        $status = $this->requestBody['status'] ?? '';

        $result = $this->controller->updateTrainStatus($id, $status);
        $this->jsonResponse($result);
    }

    public function moveTrainToNextStation()
    {
        $id = $_GET['id'] ?? '';

        $result = $this->controller->moveTrainToNextStation($id);
        $this->jsonResponse($result);
    }
}
