<?php
// إعدادات الاتصال بقاعدة البيانات
try {
    $db = new PDO('mysql:host=localhost;dbname=garcinia_Chat', 'garcinia_Chat', 'WzBEK@M;-X{D');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

