<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/StationModel.php';

class StationController extends Controller
{
    private $model;

    function __construct($requestUri)
    {
        parent::__construct($requestUri);
        $this->model = new StationModel();
    }

    public function index()
    {
        $result = $this->model->getAllStations();
        $stations = $result['data'] ?? [];

        $this->loadView('dashboard/admin/stations.php', ['stations' => $stations]);
    }

    public function getAllStations()
    {
        return $this->model->getAllStations();
    }

    public function addStation($name, $code, $city, $state, $platforms)
    {
        $errors = [];

        if (empty($name)) {
            $errors[] = 'Station name is required.';
        }
        if (empty($code)) {
            $errors[] = 'Station code is required.';
        }
        if (empty($city)) {
            $errors[] = 'City is required.';
        }
        if (empty($state)) {
            $errors[] = 'State is required.';
        }
        if (!is_numeric($platforms) || $platforms < 1) {
            $errors[] = 'Platforms must be a positive number.';
        }

        if (!empty($errors)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Validation errors occurred.',
                'errors' => $errors,
            ]);
        }

        return $this->model->addStation($name, $code, $city, $state, $platforms);
    }

    public function updateStation($id, $name, $code, $city, $state, $platforms)
    {
        $errors = [];

        if (empty($name)) {
            $errors[] = 'Station name is required.';
        }
        if (empty($code)) {
            $errors[] = 'Station code is required.';
        }
        if (empty($city)) {
            $errors[] = 'City is required.';
        }
        if (empty($state)) {
            $errors[] = 'State is required.';
        }
        if (!is_numeric($platforms) || $platforms < 1) {
            $errors[] = 'Platforms must be a positive number.';
        }

        if (!empty($errors)) {
            return $this->pass(false, 'VALIDATION_FAILED', [
                'message' => 'Validation errors occurred.',
                'errors' => $errors,
            ]);
        }

        return $this->model->updateStation($id, $name, $code, $city, $state, $platforms);
    }

    public function deleteStation($id)
    {
        return $this->model->deleteStation($id);
    }
}
