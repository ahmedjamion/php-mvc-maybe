<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $created_at;
    public string $updated_at;

    public static function findByEmail(string $email): ?self
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = Database::get()->prepare($sql);
        $stmt->execute(['email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function create(string $name, string $email, string $password): ?self
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $ok = Database::execute($sql, [
            'name' => $name,
            'email' => $email,
            'password' => $hash,
        ]);

        if (!$ok) {
            return null;
        }

        $id = (int) Database::lastInsertId();
        return self::findById($id);
    }

    public static function findById(int $id): ?self
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = Database::get()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function verifyPassword(string $plain): bool
    {
        return password_verify($plain, $this->password);
    }
}
