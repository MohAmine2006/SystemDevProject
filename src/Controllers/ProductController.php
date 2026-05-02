<?php
namespace App\Controllers;

use App\Repositories\ProductRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class ProductController
{
    public function __construct(private PhpRenderer $view, private ProductRepository $products) {}

    public function index(Request $request, Response $response): Response
    {
        $query = $request->getQueryParams();
        return $this->view->render($response, 'inventory/index.php', [
            'products' => $this->products->all($query['category'] ?? null, $query['search'] ?? null),
            'categories' => $this->products->categories(),
            'selectedCategory' => $query['category'] ?? 'All',
            'search' => $query['search'] ?? '',
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        $this->products->create((array)$request->getParsedBody());
        return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $this->products->update((int)$args['id'], (array)$request->getParsedBody());
        return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->products->softDelete((int)$args['id']);
        return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
    }
}
