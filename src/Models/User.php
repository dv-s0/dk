<?php

namespace App\Models;

use PDO;
use App\Database;

class User
{
    protected $table = 'users';

    // إنشاء مستخدم جديد
    public static function create($data)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
        return $pdo->lastInsertId();
    }

    // جلب جميع المستخدمين
    public static function all()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // البحث عن مستخدم حسب البريد الإلكتروني
    public static function where($field, $value)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE $field = :value");
        $stmt->execute([':value' => $value]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // جلب مستخدم واحد حسب معرفه
    public static function find($id)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
