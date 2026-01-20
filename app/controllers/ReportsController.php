<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/ReportsModel.php';

class ReportsController extends Controller
{
    private $model;

    public function __construct($requestUri)
    {
        parent::__construct($requestUri);
        $this->model = new ReportsModel();
    }

    public function createReport($reported_by, $issueTrain, $category, $title, $description)
    {
        $errors = [];

        if (empty($reported_by)) {
            $errors['reported_by'] = 'Reported by is required.';
        }

        if (empty($category)) {
            $errors['category'] = 'Category is required.';
        }
        if (empty($title)) {
            $errors['title'] = 'Title is required.';
        }
        if (empty($description)) {
            $errors['description'] = 'Description is required.';
        }
        if (!empty($errors)) {
            return $this->pass(false, 'VALIDATION_ERROR', [
                'errors' => $errors,
            ]);
        }

        $result = $this->model->createReport(
            $reported_by,
            $issueTrain,
            $category,
            $title,
            $description,
        );

        return $result;
    }

    public function getUserReports($userId)
    {
        $result = $this->model->getUserReports($userId);

        return $result;
    }

    public function getAllReports()
    {
        $result = $this->model->getAllReports();

        return $result;
    }

    public function removeReport($reportId)
    {
        $result = $this->model->removeReport($reportId);

        return $result;
    }
}
