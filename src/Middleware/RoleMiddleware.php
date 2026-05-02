<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class RoleMiddleware
{
    public function __construct(private string $requiredRole) {}

    public function __invoke(Request $request, Handler $handler): Response
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== $this->requiredRole) {
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
        }
        return $handler->handle($request);
    }
}
