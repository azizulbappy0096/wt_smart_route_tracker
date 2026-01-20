<?php
/**
 * define Database credentials
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'smart_route_tracker');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

const CONSTANTS = [
    'session_cookie' => '__connect_session',
];

const STATUS_CODES = [
    'SUCCESS' => 200,
    'CREATED' => 201,
    'BAD_REQUEST' => 400,
    'VALIDATION_FAILED' => 400,
    'UNAUTHORIZED' => 401,
    'FORBIDDEN' => 403,
    'NOT_FOUND' => 404,
    'CONFLICT' => 409,
    'SERVER_ERROR' => 500,
];
