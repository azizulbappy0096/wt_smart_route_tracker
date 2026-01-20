<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/TrainModel.php';

class TrainController extends Controller
{
    private $model;

    public function __construct($requestUri)
    {
        parent::__construct($requestUri);
        $this->model = new TrainModel();
    }

    public function index()
    {
        $result = $this->model->getAllTrains();
        $trains = $result['data'] ?? [];

        $this->loadView('dashboard/admin/trains.php', ['trains' => $trains]);
    }

    public function getAllTrains()
    {
        $result = $this->model->getAllTrains();

        return $result;
    }

    public function searchTrains($query = null, $station = null, $type = null)
    {
        $result = $this->model->searchTrains($query, $station, $type);

        return $result;
    }

    public function addTrain($name, $number, $type, $speed, $start_station, $end_station, $route)
    {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Train name is required.';
        }
        if (empty($number)) {
            $errors['number'] = 'Train number is required.';
        }
        if (empty($type)) {
            $errors['type'] = 'Train type is required.';
        }
        if (empty($speed) || !is_numeric($speed)) {
            $errors['speed'] = 'Valid speed is required.';
        }

        if (!empty($errors)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Validation errors occurred.',
                'errors' => $errors,
            ]);
        }

        return $this->model->addTrain(
            $name,
            $number,
            $type,
            $speed,
            $start_station,
            $end_station,
            $route,
        );
    }

    public function updateTrain(
        $id,
        $name,
        $number,
        $type,
        $speed,
        $start_station,
        $end_station,
        $route,
    ) {
        $errors = [];
        if (empty($id) || !is_numeric($id)) {
            $errors['id'] = 'Valid train ID is required.';
        }
        if (empty($name)) {
            $errors['name'] = 'Train name is required.';
        }
        if (empty($number)) {
            $errors['number'] = 'Train number is required.';
        }
        if (empty($type)) {
            $errors['type'] = 'Train type is required.';
        }
        if (empty($speed) || !is_numeric($speed)) {
            $errors['speed'] = 'Valid speed is required.';
        }
        if (!empty($errors)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Validation errors occurred.',
                'errors' => $errors,
            ]);
        }
        return $this->model->updateTrain(
            $id,
            $name,
            $number,
            $type,
            $speed,
            $start_station,
            $end_station,
            $route,
        );
    }

    public function deleteTrain($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Valid train ID is required.',
            ]);
        }
        return $this->model->deleteTrain($id);
    }

    public function updateTrainStatus($id, $status)
    {
        $errors = [];

        if (empty($id) || !is_numeric($id)) {
            $errors['id'] = 'Valid train ID is required.';
        }
        if (empty($status)) {
            $errors['status'] = 'Train status is required.';
        }
        if (!empty($errors)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Validation errors occurred.',
                'errors' => $errors,
            ]);
        }

        return $this->model->updateTrainStatus($id, $status);
    }

    public function getTrainById($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Valid train ID is required.',
            ]);
        }
        return $this->model->getTrainById($id);
    }

    public function moveTrainToNextStation($trainId)
    {
        if (empty($trainId) || !is_numeric($trainId)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Valid train ID is required.',
            ]);
        }

        return $this->model->moveTrainToNextStation($trainId);
    }
}
