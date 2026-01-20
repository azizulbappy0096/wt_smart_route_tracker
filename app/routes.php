<?php
/**
 *  define routes with its controllers and actions
 */
const routes = [
    '/' => ['HomeController', 'index'],
    '/home' => ['HomeController', 'index'],
    '/login' => ['AuthController', 'loginView'],
    '/register' => ['AuthController', 'registerView'],
    '/forgot-password' => ['AuthController', 'forgotPasswordView'],
    '/dashboard/profile' => ['dashboard/ProfileController', 'index'],
    // dashboard routes --> general
    '/dashboard' => ['dashboard/GeneralController', 'searchTrainsView'],
    '/dashboard/tracking' => ['dashboard/GeneralController', 'trackingView'],
    '/dashboard/favorites' => ['dashboard/GeneralController', 'favoritesView'],
    '/dashboard/report-issue' => ['dashboard/GeneralController', 'reportIssueView'],
    '/dashboard/notifications' => ['dashboard/GeneralController', 'notificationsView'],
    // dashboard routes --> admin
    '/dashboard/admin' => ['dashboard/AdminController', 'adminPanelView'],
    '/dashboard/admin/trains' => ['TrainController', 'index'],
    '/dashboard/admin/stations' => ['StationController', 'index'],
    '/dashboard/admin/users' => ['dashboard/AdminController', 'manageUsersView'],
    '/dashboard/admin/reports' => ['dashboard/AdminController', 'manageReportsView'],
];

const apiRoutes = [
    '/api/auth/register' => ['AuthApiController', 'register', 'post'],
    '/api/auth/login' => ['AuthApiController', 'login', 'post'],
    '/api/auth/logout' => ['AuthApiController', 'logout', 'get'],
    // stations
    '/api/stations' => ['StationApiController', 'getAllStations', 'get'],
    '/api/stations/add' => ['StationApiController', 'addStation', 'post'],
    '/api/stations/update' => ['StationApiController', 'updateStation', 'put'],
    '/api/stations/delete' => ['StationApiController', 'deleteStation', 'delete'],
    // trains
    '/api/trains/add' => ['TrainApiController', 'addTrain', 'post'],
    '/api/trains/update' => ['TrainApiController', 'updateTrain', 'put'],
    '/api/trains/delete' => ['TrainApiController', 'deleteTrain', 'delete'],
    '/api/trains/status' => ['TrainApiController', 'updateTrainStatus', 'put'],
    '/api/trains/move-next' => ['TrainApiController', 'moveTrainToNextStation', 'get'],
    // favorites
    '/api/favorites/toggle' => ['FavoritesApiController', 'toggleFavorite', 'post'],
    '/api/favorites/user' => ['FavoritesApiController', 'getUserFavorites', 'get'],
    // reports
    '/api/reports/remove' => ['ReportApiController', 'removeReport', 'delete'],
];
