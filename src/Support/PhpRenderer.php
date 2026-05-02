<?php
namespace Slim\Views;

use Psr\Http\Message\ResponseInterface as Response;

class PhpRenderer
{
    public function __construct(private string $templatePath) {}

    public function render(Response $response, string $template, array $data = []): Response
    {
        $html = $this->fetch($template, $data);
        $response->getBody()->write($html);
        return $response;
    }

    public function fetch(string $template, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        ob_start();
        include rtrim($this->templatePath, '/\\') . DIRECTORY_SEPARATOR . $template;
        return ob_get_clean();
    }
}
