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
        $query       = $request->getQueryParams();
        $allProducts = $this->products->all();
        $filtered    = $this->products->all($query['category'] ?? null, $query['search'] ?? null);

        $totalItems    = (int) array_sum(array_column($allProducts, 'quantity'));
        $totalProducts = count($allProducts);
        $lowStock      = count(array_filter($allProducts, fn($p) => (int)$p['quantity'] <= (int)$p['low_stock_threshold']));
        $overstock     = count(array_filter($allProducts, fn($p) => (int)$p['quantity'] >= (int)$p['max_stock_threshold']));
        $totalValue    = array_sum(array_map(fn($p) => (float)$p['price'] * (int)$p['quantity'], $allProducts));

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        return $this->view->render($response, 'inventory/index.php', [
            'products'         => $filtered,
            'categories'       => $this->products->categories(),
            'selectedCategory' => $query['category'] ?? 'All',
            'search'           => $query['search'] ?? '',
            'flash'            => $flash,
            'stats'            => [
                'total_items'    => $totalItems,
                'total_products' => $totalProducts,
                'low_stock'      => $lowStock,
                'overstock'      => $overstock,
                'total_value'    => $totalValue,
            ],
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            $this->products->create((array)$request->getParsedBody());
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Product added successfully.'];
        } catch (\Throwable $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Could not add product: ' . $e->getMessage()];
        }
        return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        try {
            $this->products->update((int)$args['id'], (array)$request->getParsedBody());
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Product updated successfully.'];
        } catch (\Throwable $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Could not update product: ' . $e->getMessage()];
        }
        return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        try {
            $this->products->softDelete((int)$args['id']);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Product deleted.'];
        } catch (\Throwable $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Could not delete product: ' . $e->getMessage()];
        }
        return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
    }
}
