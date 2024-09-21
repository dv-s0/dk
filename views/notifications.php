<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4">Notifications</h1>
    <div id="notificationsContainer" class="mt-3">
        <!-- يتم جلب الإشعارات هنا باستخدام AJAX -->
    </div>
</div>

<script>
    // جلب الإشعارات اللحظية باستخدام AJAX
    function fetchNotifications() {
        fetch('/api/notifications')
            .then(response => response.json())
            .then(data => {
                let html = '';
                data.forEach(notification => {
                    html += `<div class="alert alert-info">${notification.message}</div>`;
                });
                document.getElementById('notificationsContainer').innerHTML = html;
            });
    }

    // تحديث الإشعارات كل 10 ثوانٍ
    setInterval(fetchNotifications, 10000);
    fetchNotifications();
</script>

<?php include 'footer.php'; ?>
