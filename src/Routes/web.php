<?php
use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\ReportController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/', fn($req, $res) => $res->withHeader('Location', \App\Config\Helpers::url('/login'))->withStatus(302));

    $app->get('/login', [AuthController::class, 'loginPage']);
    $app->post('/login', [AuthController::class, 'login']);
    $app->post('/logout', [AuthController::class, 'logout']);

    // Language toggle — works on every page including login
    $app->get('/lang/{code}', function ($req, $res, $args) {
        $code = $args['code'];
        if (in_array($code, ['en', 'fr'], true)) {
            $_SESSION['lang'] = $code;
        }
        $referer = $req->getHeaderLine('Referer') ?: \App\Config\Helpers::url('/inventory');
        return $res->withHeader('Location', $referer)->withStatus(302);
    });

    $app->group('', function ($group) {
        $group->get('/inventory', [ProductController::class, 'index']);
        $group->post('/products/{id}/update', [ProductController::class, 'update']);
        $group->post('/products', [ProductController::class, 'create'])->add(new RoleMiddleware('owner'));
        $group->post('/products/{id}/delete', [ProductController::class, 'delete'])->add(new RoleMiddleware('owner'));
        $group->get('/reports', [ReportController::class, 'index'])->add(new RoleMiddleware('owner'));
        $group->post('/reports/pdf', [ReportController::class, 'generatePdf'])->add(new RoleMiddleware('owner'));
    })->add(new AuthMiddleware());
};
