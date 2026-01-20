<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/FavoritesModel.php';

class FavoritesController extends Controller
{
    private $model;

    public function __construct($requestUri)
    {
        parent::__construct($requestUri);
        $this->model = new FavoritesModel();
    }

    public function getUserFavorites($userId)
    {
        $result = $this->model->getUserFavorites($userId);

        return $result;
    }

    public function isFavorite($userId, $trainId)
    {
        $result = $this->model->isFavorite($userId, $trainId);

        return $result['data']['is_favorite'] ?? false;
    }
}
