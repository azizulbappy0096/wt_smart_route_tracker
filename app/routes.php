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
    // dashboard routes --> general
    '/dashboard' => ['dashboard/GeneralController', 'searchTrainsView'],
    '/dashboard/tracking' => ['dashboard/GeneralController', 'trackingView'],
    '/dashboard/favorites' => ['dashboard/GeneralController', 'favoritesView'],
    '/dashboard/report-issue' => ['dashboard/GeneralController', 'reportIssueView'],
    '/dashboard/notifications' => ['dashboard/GeneralController', 'notificationsView'],
    // dashboard routes --> admin
    '/dashboard/admin' => ['dashboard/AdminController', 'adminPanelView'],
    '/dashboard/admin/trains' => ['dashboard/AdminController', 'manageTrainsView'],
    '/dashboard/admin/stations' => ['dashboard/AdminController', 'manageStationsView'],
    '/dashboard/admin/users' => ['dashboard/AdminController', 'manageUsersView'],
    '/dashboard/admin/reports' => ['dashboard/AdminController', 'manageReportsView'],
];
