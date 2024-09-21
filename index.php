<?php
// public/index.php

// بدء الجلسة وتفعيل الأمان للجلسات
session_start();

// حماية الجلسات بإعادة تجديد معرف الجلسة
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}

// تضمين ملف إعدادات قاعدة البيانات
require_once 'config/database.php';

// تضمين ملفات الكونترولر المطلوبة
require_once 'src/Controllers/UserController.php';
require_once 'src/Controllers/MessageController.php';
require_once 'src/Controllers/CommentController.php';
require_once 'src/Controllers/CampaignController.php';
require_once 'src/Controllers/LeadController.php';

// تحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header('Location: views/login.php');
    exit;
}

// إعداد الأدوار والصلاحيات
$userController = new UserController($pdo);
$user = $userController->getUserById($_SESSION['user_id']);

if (!$user) {
    // إذا لم يتم العثور على المستخدم، قم بتسجيل الخروج
    session_destroy();
    header('Location: views/login.php');
    exit;
}

// إعداد الرموز المميزة OAuth مع Facebook SDK (تأكد من تثبيت Facebook SDK عبر Composer)
require_once 'vendor/autoload.php';

$fb = new \Facebook\Facebook([
    'app_id' => '1055581979526435',
    'app_secret' => '26ce16878cd1612308f84fff886da95a',
    'default_graph_version' => 'v15.0',
]);

// إعداد كونترولرز الرسائل والتعليقات والحملات والإشعارات
$messageController = new MessageController($fb, $pdo);
$commentController = new CommentController($fb, $pdo);
$campaignController = new CampaignController($fb, $pdo);
$leadController = new LeadController($pdo);

// جلب البيانات اللازمة للعرض في لوحة التحكم
$messages = $messageController->getMessages();
$comments = $commentController->getComments();
$campaigns = $campaignController->getCampaigns();
$leads = $leadController->getLeads();

// جلب بيانات الحملات لتحليلها بواسطة ChatGPT (افتراض وجود دالة تحليل في CampaignController)
$campaignAnalysis = $campaignController->analyzeCampaigns();

// إعداد إشعارات لحظية (يمكن أن يتم جلبها عبر WebSockets أو AJAX)
$notifications = $messageController->getNotifications();

// تضمين واجهة لوحة التحكم
include 'views/dashboard.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
