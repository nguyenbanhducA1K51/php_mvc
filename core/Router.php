<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{

    protected array $routes;
    public Response $response;
    public Request $request;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function get($path, $callback)
    {

        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {

        $path = $this->request->getPath();

        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback == false) {

            $this->response->setStatusCode(404);
            throw new NotFoundException();

        }
        if (is_array($callback)) {

            $instance = new $callback[0]();


            # there is only 1 instance of application, but different url(or api) 
            #will  initiate different controller for this application
            # router is in the middle man of application and controller and there is 1 router instance only with multiple routes

            Application::$app->controller = $instance;
            Application::$app->controller->action = $callback[1];

            foreach ($instance->getMiddlewares() as $middleware) {
                $middleware->execute();
            }

        }
        return call_user_func([$instance, $callback[1]], $this->request, $this->response);
    }

    # note that the method home in site controller does not have 
    # param request, only the method handle contact use, it seems like this is optional

}