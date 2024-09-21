<?php

namespace App\Models;

use PDO;
use App\Database;

class Lead
{
    protected $table = 'leads';

    // إنشاء Lead جديد
    public static function create($data)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO leads (phone, message_id) VALUES (:phone, :message_id)");
        $stmt->execute([
            ':phone' => $data['phone'],
            ':message_id' => $data['message_id']
        ]);
        return $pdo->lastInsertId();
    }

    // جلب جميع الـ Leads
    public static function all()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM leads");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // البحث عن Lead حسب معرف الرسالة
    public static function whereMessageId($messageId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM leads WHERE message_id = :message_id");
        $stmt->execute([':message_id' => $messageId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
