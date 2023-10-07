<?php

namespace app\core;

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

            return $this->renderView("_404");
            exit;
        }
        if (is_array($callback)) {

            $instance = new $callback[0]();

            # there is only 1 instance of application, but different url(or api) 
            #will  initiate different controller for this application
            # router is in the middle man of application and controller and there is 1 router instance only with multiple routes

            Application::$app->controller = $instance;
            return call_user_func([$instance, $callback[1]], $this->request);
        }
        return null;
        # note that the method home in site controller does not have 
        # param request, only the method handle contact use, it seems like this is optional

    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        # search for {{content }} inside $layout and replace with $viewContent
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        # search for {{content }} inside $layout and replace with param #viewcontent
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }


    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        # it actually start to  cache/buffer the output of the browser 
        ob_start();
        # include_once seem to paste the content from the path below
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();

        #it return output of the browser, not render it 

    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            # note , here it take the  key, make it the new variable and assign the value
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
