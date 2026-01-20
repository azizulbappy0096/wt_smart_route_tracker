<?php

require_once BASE_PATH . '/core/ApiController.php';
require_once BASE_PATH . '/app/models/FavoritesModel.php';

class FavoritesApiController extends ApiController
{
    private $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new FavoritesModel();
    }

    public function getUserFavorites()
    {
        $userId = $_GET['id'] ?? '';

        if (empty($userId)) {
            $this->jsonResponse([
                'success' => false,
                'status' => 'VALIDATION_FAILED',
                'message' => 'User ID is required',
            ]);
            return;
        }

        $result = $this->model->getUserFavorites($userId);
        $this->jsonResponse($result);
    }

    public function toggleFavorite()
    {
        $userId = $this->requestBody['user_id'] ?? '';
        $trainId = $this->requestBody['train_id'] ?? '';

        $errors = [];
        if (empty($userId)) {
            $errors['user_id'] = 'User ID is required.';
        }
        if (empty($trainId)) {
            $errors['train_id'] = 'Train ID is required.';
        }
        if (!empty($errors)) {
            $this->jsonResponse([
                'success' => false,
                'status' => 'VALIDATION_FAILED',
                'message' => 'Validation errors occurred.',
                'errors' => $errors,
            ]);
            return;
        }

        $result = $this->model->toggleFavorite($userId, $trainId);
        $this->jsonResponse($result);
    }
}
