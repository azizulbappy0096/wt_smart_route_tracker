<?php

require BASE_PATH . '/core/Controller.php';

class ProfileController extends Controller
{
    function __construct() {}

    public function index()
    {
        $this->loadView('dashboard/profile.php');
    }
}
