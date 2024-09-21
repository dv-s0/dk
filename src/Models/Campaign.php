<?php

namespace App\Models;

use PDO;
use App\Database;

class Campaign
{
    protected $table = 'campaigns';

    // إنشاء حملة إعلانية جديدة
    public static function create($data)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO campaigns (name, budget, start_date, end_date) VALUES (:name, :budget, :start_date, :end_date)");
        $stmt->execute([
            ':name' => $data['name'],
            ':budget' => $data['budget'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date']
        ]);
        return $pdo->lastInsertId();
    }

    // جلب جميع الحملات الإعلانية
    public static function all()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM campaigns");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // جلب حملة إعلانية واحدة حسب معرفها
    public static function find($id)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM campaigns WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // تحديث بيانات الحملة الإعلانية
    public static function update($id, $data)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE campaigns SET name = :name, budget = :budget, start_date = :start_date, end_date = :end_date WHERE id = :id");
        $stmt->execute([
            ':name' => $data['name'],
            ':budget' => $data['budget'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':id' => $id
        ]);
    }

    // حذف حملة إعلانية
    public static function delete($id)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM campaigns WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}

