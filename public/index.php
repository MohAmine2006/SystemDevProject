<?php
use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\ReportController;
use App\Repositories\ProductRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use DI\Container;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';

session_start();

if (file_exists(__DIR__ . '/../.env')) {
    Dotenv::createImmutable(__DIR__ . '/../')->safeLoad();
}

$container = new Container();
$container->set(PhpRenderer::class, fn() => new PhpRenderer(__DIR__ . '/../templates'));
$container->set(UserRepository::class, fn() => new UserRepository());
$container->set(ProductRepository::class, fn() => new ProductRepository());
$container->set(ReportRepository::class, fn() => new ReportRepository());
$container->set(AuthController::class, fn($c) => new AuthController($c->get(PhpRenderer::class), $c->get(UserRepository::class)));
$container->set(ProductController::class, fn($c) => new ProductController($c->get(PhpRenderer::class), $c->get(ProductRepository::class)));
$container->set(ReportController::class, fn($c) => new ReportController($c->get(PhpRenderer::class), $c->get(ProductRepository::class), $c->get(ReportRepository::class)));

AppFactory::setContainer($container);
$app = AppFactory::create();
$basePath = $_ENV['BASE_PATH'] ?? '';
if ($basePath !== '') {
    $app->setBasePath($basePath);
}
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

(require __DIR__ . '/../src/Routes/web.php')($app);
$app->run();
