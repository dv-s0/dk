<?php
session_start();

// التحقق مما إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
// تحقق من وجود البيانات قبل الاستخدام
$messages = getMessagesFromDB() ?: [];
$comments = getCommentsFromDB() ?: [];
$leads = getLeadsFromDB() ?: [];
$notifications = getNotificationsFromDB() ?: [];
$campaigns = getCampaignsFromDB() ?: [];

// مثال لمصفوفة فارغة إذا لم توجد بيانات
if (isset($campaigns) && is_array($campaigns)) {
    $campaignNames = array_column($campaigns, 'name');
} else {
    $campaignNames = [];
}


<!-- عرض الرسائل -->
<?php if (isset($messages) && is_array($messages)) : ?>
    <?php foreach ($messages as $message) : ?>
        <!-- عرض كل رسالة -->
    <?php endforeach; ?>
<?php else : ?>
    <p>لا توجد رسائل.</p>
<?php endif; ?>

<!-- عرض التعليقات -->
<?php if (isset($comments) && is_array($comments)) : ?>
    <?php foreach ($comments as $comment) : ?>
        <!-- عرض كل تعليق -->
    <?php endforeach; ?>
<?php else : ?>
    <p>لا توجد تعليقات.</p>
<?php endif; ?>

<!-- عرض الـ Leads -->
<?php if (isset($leads) && is_array($leads)) : ?>
    <?php foreach ($leads as $lead) : ?>
        <!-- عرض كل Lead -->
    <?php endforeach; ?>
<?php else : ?>
    <p>لا توجد Leads.</p>
<?php endif; ?>

<!-- عرض الإشعارات -->
<?php if (isset($notifications) && is_array($notifications)) : ?>
    <?php foreach ($notifications as $notification) : ?>
        <!-- عرض كل إشعار -->
    <?php endforeach; ?>
<?php else : ?>
    <p>لا توجد إشعارات.</p>
<?php endif; ?>

<!-- عرض الحملات الإعلانية -->
<?php if (isset($campaigns) && is_array($campaigns)) : ?>
    <?php foreach ($campaigns as $campaign) : ?>
        <!-- عرض كل حملة -->
    <?php endforeach; ?>
<?php else : ?>
    <p>لا توجد حملات إعلانية.</p>
<?php endif; ?>
<?php
if (isset($campaigns) && is_array($campaigns)) {
    $campaignNames = array_column($campaigns, 'name');
} else {
    $campaignNames = []; // إذا لم تكن هناك حملات، قم بإعداد مصفوفة فارغة
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- شريط التنقل العلوي -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">مدير فيسبوك</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">الصفحة الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="campaign_analysis.php">تحليل الحملات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="notifications.php">الإشعارات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- محتوى لوحة التحكم -->
    <div class="container mt-4">
        <h1 class="mb-4">مرحبا بك في لوحة التحكم</h1>

        <!-- قسم الرسائل -->
        <div class="row">
            <div class="col-md-6">
                <h3>الرسائل</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>المرسل</th>
                            <th>الرسالة</th>
                            <th>تاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?= htmlspecialchars($message['sender_name']) ?></td>
                                <td><?= htmlspecialchars($message['content']) ?></td>
                                <td><?= htmlspecialchars($message['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- قسم التعليقات -->
            <div class="col-md-6">
                <h3>التعليقات</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>المعلق</th>
                            <th>التعليق</th>
                            <th>تاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td><?= htmlspecialchars($comment['commenter_name']) ?></td>
                                <td><?= htmlspecialchars($comment['content']) ?></td>
                                <td><?= htmlspecialchars($comment['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- قسم الحملات الإعلانية -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>الحملات الإعلانية</h3>
                <canvas id="campaignChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- قسم الـ Leads -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>الـ Leads</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>رقم الهاتف</th>
                            <th>تاريخ الإنشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $lead): ?>
                            <tr>
                                <td><?= htmlspecialchars($lead['phone_number']) ?></td>
                                <td><?= htmlspecialchars($lead['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- قسم الإشعارات اللحظية -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <?php foreach ($notifications as $notification): ?>
            <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?= htmlspecialchars($notification['message']) ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- تضمين مكتبات JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/websocket.js"></script>

    <!-- كود JavaScript لتحليل الحملات باستخدام Chart.js -->
    <script>
        const ctx = document.getElementById('campaignChart').getContext('2d');
        const campaignChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($campaigns, 'name')) ?>,
                datasets: [{
                    label: 'النقرات',
                    data: <?= json_encode(array_column($campaigns, 'clicks')) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'الوصول',
                    data: <?= json_encode(array_column($campaigns, 'reach')) ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'الإنفاق',
                    data: <?= json_encode(array_column($campaigns, 'spend')) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
