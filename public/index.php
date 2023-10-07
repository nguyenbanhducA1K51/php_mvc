<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
// sudo apt-get install php5-mysql

// require_once __DIR__."/../core/Application.php";
// require_once __DIR__."/../controllers/SiteController.php";
// require_once __DIR__."/../controllers/AuthController.php";

phpinfo();
$config=[

    'db'=> [
        'dsn'=>$_ENV['DB_DSN'],
        'user'=> $_ENV['DB_USER'],
        'password'=> $_ENV['DB_PASSWORD']
    ]
];

// phpinfo();
if (!defined('PDO::ATTR_DRIVER_NAME')) {
    echo 'PDO unavailable';
    }
// /etc/php/8.1/cli
$app = new Application(dirname(__DIR__), $config);
$app->router->get('/', [SiteController::class, 'home']);

# https://php.watch/versions/8.0/non-static-static-call-fatal-error
#non  static callback is no longer available
$app->router->get('/contact', [SiteController::class, 'contact']);
# the function call_user_function in router will execute  function 'contact' in SiteController class
$app->router->post('/contact', [SiteController::class, 'handleContact']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class,'register']);

$app->router->post('/register', [AuthController::class,'register']);

$app->run();
