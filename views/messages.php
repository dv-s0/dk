<?php
require_once '../src/Controllers/MessageController.php';
$token = 'YOUR_FACEBOOK_PAGE_ACCESS_TOKEN';
$messageController = new MessageController($token);
$messages = $messageController->getMessages(); // افترض أن هذه الدالة تسترجع الرسائل

?>
<div class="container">
    <h2>الرسائل</h2>
    <table class="table">
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
