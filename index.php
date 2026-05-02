<?php
use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\ReportController;
use App\Repositories\ProductRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

session_start();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Support/PhpRenderer.php';

// Load .env without needing vlucas/phpdotenv, so it works like your Wampoon lab.
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
    }
}

// Auto-detect the folder name in the URL: /FinalSysDevProject
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($scriptDir === '/') $scriptDir = '';
$_ENV['BASE_PATH'] = $_ENV['BASE_PATH'] ?? $scriptDir;

$container = new Container();
$container->set(PhpRenderer::class, fn() => new PhpRenderer(__DIR__ . '/templates'));
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

(require __DIR__ . '/src/Routes/web.php')($app);
$app->run();
