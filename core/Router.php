<?php

require BASE_PATH . '/app/routes.php';

class Router
{
    private $request;
    private $requestMethod;

    public function __construct()
    {
        $this->request = trim($_SERVER['REQUEST_URI']);
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    public function run()
    {
        if (strpos($this->request, '/api/') === 0) {
            $this->apiRoute();
        } else {
            $this->route();
        }
    }

    private function route()
    {
        if (array_key_exists($this->request, routes)) {
            $route = routes[$this->request];
            $controller = $route[0];
            $method = $route[1];
            $allowedMethod = 'GET';

            // Check HTTP method
            $this->checkMethod($allowedMethod);

            $filePath = BASE_PATH . '/app/controllers/' . $controller . '.php';

            if (file_exists($filePath)) {
                require_once $filePath;
                $controller = explode('/', $controller)[count(explode('/', $controller)) - 1];
                $class = new $controller($this->request);
                if (method_exists($controller, $method)) {
                    $class->$method();
                    return;
                }
            }
        }

        http_response_code(404);
        include BASE_PATH . '/app/views/pages/not_found.php';
    }

    private function apiRoute()
    {
        if (array_key_exists($this->request, apiRoutes)) {
            $route = apiRoutes[$this->request];
            $controller = $route[0];
            $method = $route[1];
            $allowedMethod = strtoupper($route[2] ?? 'GET');

            // Check HTTP method
            $this->checkMethod($allowedMethod);

            $filePath = BASE_PATH . '/app/api/' . $controller . '.php';

            if (file_exists($filePath)) {
                require_once $filePath;
                $controller = explode('/', $controller)[count(explode('/', $controller)) - 1];
                $class = new $controller();
                if (method_exists($controller, $method)) {
                    $class->$method();
                    return;
                }
            }
        }

        $this->jsonResponse(false, 'Not found', 404);
    }

    private function checkMethod($allowedMethod)
    {
        if ($this->requestMethod !== $allowedMethod) {
            header('Content-Type: application/json');
            http_response_code(405);
            $response = [
                'success' => false,
                'status' => 405,
                'message' => "Method $this->requestMethod not allowed.",
                'data' => null,
            ];
            echo json_encode($response);
            exit();
        }
    }
}
