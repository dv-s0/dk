<?php
require_once '../src/Controllers/CommentController.php';
$token = 'YOUR_FACEBOOK_PAGE_ACCESS_TOKEN';
$commentController = new CommentController($token);
$comments = $commentController->getComments(); // افترض أن هذه الدالة تسترجع التعليقات

?>
<div class="container">
    <h2>التعليقات</h2>
    <table class="table">
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
