<?php
/**
 * Main controller class
 */
class Controller
{

    function __construct()
    {

    }

    public function loadView($name = '', $arg = array())
    {
        $path = BASE_PATH . "/app/views/pages/{$name}";
        // $data = array();

        // foreach ($arg as $key => $value) {
        //     $data[$key] = $value;
        // }
        extract($arg);

        ob_start();
        include($path);
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;
    }
}
