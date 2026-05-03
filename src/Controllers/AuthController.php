<?php
namespace App\Controllers;

use App\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class AuthController
{
    public function __construct(private PhpRenderer $view, private UserRepository $users) {}

    public function loginPage(Request $request, Response $response): Response
    {
        if (!empty($_SESSION['user'])) return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
        return $this->view->render($response, 'auth/login.php', ['error' => $_SESSION['error'] ?? null]);
    }

    public function login(Request $request, Response $response): Response
    {
        $data = (array)$request->getParsedBody();
        $user = $this->users->findByUsername(trim($data['username'] ?? ''));

        if (!$user || !password_verify($data['password'] ?? '', $user['password_hash'])) {
            $_SESSION['error'] = 'invalid_credentials';
            return $response->withHeader('Location', \App\Config\Helpers::url('/login'))->withStatus(302);
        }

        unset($_SESSION['error']);
        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
        ];
        $this->users->updateLoginStatus((int)$user['id'], 'logged in');
        return $response->withHeader('Location', \App\Config\Helpers::url('/inventory'))->withStatus(302);
    }

    public function logout(Request $request, Response $response): Response
    {
        if (!empty($_SESSION['user'])) $this->users->updateLoginStatus((int)$_SESSION['user']['id'], 'logged out');
        session_destroy();
        return $response->withHeader('Location', \App\Config\Helpers::url('/login'))->withStatus(302);
    }
}
