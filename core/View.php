<?php 
namespace app\core;

class View
{

    public string $title = '';
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        # search for {{content }} inside $layout and replace with param #viewcontent
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }


    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if (isset(Application::$app->controller)) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();

    }

    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
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

    
    ?>