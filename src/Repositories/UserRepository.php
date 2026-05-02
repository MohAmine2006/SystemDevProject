<?php
namespace App\Repositories;

use App\Config\Database;

class UserRepository
{
    public function findByUsername(string $username): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch() ?: null;
    }

    public function updateLoginStatus(int $id, string $status): void
    {
        $stmt = Database::getConnection()->prepare('UPDATE users SET login_status = :status WHERE id = :id');
        $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
