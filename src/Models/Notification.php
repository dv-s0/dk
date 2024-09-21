<?php

namespace App\Models;

use PDO;
use App\Database;

class Notification
{
    protected $table = 'notifications';

    // إنشاء إشعار جديد
    public static function create($data)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message, type, is_read) VALUES (:user_id, :message, :type, :is_read)");
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':message' => $data['message'],
            ':type' => $data['type'],
            ':is_read' => $data['is_read']
        ]);
        return $pdo->lastInsertId();
    }

    // جلب جميع الإشعارات
    public static function all()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM notifications");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // تحديث حالة الإشعار كمقروء
    public static function markAsRead($id)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    // جلب الإشعارات غير المقروءة
    public static function unread()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM notifications WHERE is_read = 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
