<?php
/**
 * Main controller class
 */
class Controller
{
    private $requestUri;

    function __construct($requestUri)
    {
        $this->requestUri = $requestUri;
    }

    public function loadView($name = '', $arg = [])
    {
        $path = BASE_PATH . "/app/views/pages/{$name}";
        // $data = array();

        // foreach ($arg as $key => $value) {
        //     $data[$key] = $value;
        // }
        extract($arg);
        extract(['requestUri' => $this->requestUri]);
        ob_start();
        include $path;
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;
    }

    protected function pass($success, $status, $arg = [])
    {
        return [
            'success' => $success,
            'status' => $status,
            ...$arg,
        ];
    }
}
