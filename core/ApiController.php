<?php

abstract class ApiController
{
    protected $requestBody;
    protected $files;

    function __construct()
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            $this->requestBody = json_decode(file_get_contents('php://input'), true) ?? [];
            $this->files = [];
        } else {
            $this->requestBody = $_POST;
            $this->files = $_FILES;
        }
    }

    protected function jsonResponse($arg = [])
    {
        $code = STATUS_CODES[$arg['status']] ?? 200;
        $response = [
            'success' => $arg['success'],
            'status' => $arg['status'],
            'code' => $code,
            'message' => $arg['message'],
        ];

        if (isset($arg['data']) && $arg['data'] !== null) {
            $response['data'] = $arg['data'];
        }
        if (isset($arg['errors']) && $arg['errors'] !== null) {
            $response['errors'] = $arg['errors'];
        }

        header('Content-Type: application/json');
        http_response_code($code);

        echo json_encode($response);
    }
}
