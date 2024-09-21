// scripts.js

document.addEventListener('DOMContentLoaded', function() {
    // تفعيل إشعارات التوست (Toast) عند التحميل
    const toastElements = document.querySelectorAll('.toast');
    toastElements.forEach(function(toastElement) {
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    });

    // رسم بيانات الحملات الإعلانية باستخدام Chart.js
    if (document.getElementById('campaignChart')) {
        const ctx = document.getElementById('campaignChart').getContext('2d');

        // مثال على البيانات التي قد تحصل عليها من PHP
        const campaignData = JSON.parse(document.getElementById('campaignChart').getAttribute('data-campaigns'));
        const labels = campaignData.map(campaign => campaign.name);
        const impressions = campaignData.map(campaign => campaign.impressions);
        const clicks = campaignData.map(campaign => campaign.clicks);

        // إنشاء المخطط
        const campaignChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'عدد المشاهدات',
                        data: impressions,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'عدد النقرات',
                        data: clicks,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
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
    }

    // تحديث الإشعارات اللحظية باستخدام WebSocket أو AJAX
    // استبدال الرابط برابط WebSocket أو استخدام API للإشعارات اللحظية
    

    notificationSocket.onmessage = function(event) {
        const data = JSON.parse(event.data);
        if (data.notification) {
            displayNotification(data.notification);
        }
    };

    function displayNotification(notification) {
        // إنشاء Toast جديد لعرض الإشعار
        const toastContainer = document.querySelector('.toast-container');
        const newToast = document.createElement('div');
        newToast.classList.add('toast', 'align-items-center', 'text-bg-primary', 'border-0');
        newToast.setAttribute('role', 'alert');
        newToast.setAttribute('aria-live', 'assertive');
        newToast.setAttribute('aria-atomic', 'true');

        newToast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${notification.message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        toastContainer.appendChild(newToast);

        // تفعيل Toast
        const toast = new bootstrap.Toast(newToast);
        toast.show();
    }

    // تنفيذ وظائف أخرى...
    // إضافة المزيد من الوظائف الجافا سكريبت حسب الحاجة
});

