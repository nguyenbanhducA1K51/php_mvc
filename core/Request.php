<?php

namespace app\core;
// require_once __DIR__."..\core\Router.php";
// require_once __DIR__."..\core\Response.php";
// require_once __DIR__."..\core\Request.php";

class Request
{
    public function getPath()
    {

        //  what is  _SERVER here ?
        //         $_SERVER['REQUEST_URI']:

        // $_SERVER['REQUEST_URI'] is used to retrieve the current request's Uniform Resource Identifier (URI).
        //  It typically includes the path and query string.


        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }
    public function method()
    {
        // $_SERVER['REQUEST_METHOD']: This part of the expression retrieves the HTTP request method used in the current HTTP request. 
        // Common request methods include 'GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS', and others.

        // strtolower(): This function is used to convert the retrieved request method to lowercase. For example, it ensures that 'GET' becomes 'get', 'POST' becomes 'post', and so on.

        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function isGet()
    {
        return $this->method() == 'get';
    }

    public function isPost()
    {
        return $this->method() == 'post';
    }

    public function getBody()
    {
        $body = [];
        if ($this->method() === "get") {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() == "post") {


            foreach ($_POST as $key => $value) {

                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
