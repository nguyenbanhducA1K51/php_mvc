
<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
$config=[

    'db'=> [
        'dsn'=>$_ENV['DB_DSN'],
        'user'=> $_ENV['DB_USER'],
        'password'=> $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__), $config);
$app->router->get('/', [SiteController::class, 'home']);

# https://php.watch/versions/8.0/non-static-static-call-fatal-error
#non  static callback is no longer available
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class,'register']);
$app->router->post('/register', [AuthController::class,'register']);
$app->run();
