// public/js/websocket.js

document.addEventListener('DOMContentLoaded', function () {
    // إنشاء اتصال WebSocket
    const socket = new WebSocket('ws://yourdomain.com/websocket_server/websocket_server.php');

    // عند فتح الاتصال
    socket.addEventListener('open', function (event) {
        console.log('تم الاتصال بخادم WebSocket');
    });

    // عند استقبال رسالة
    socket.addEventListener('message', function (event) {
        const data = JSON.parse(event.data);
        showToast(data.message);
    });

    // عند إغلاق الاتصال
    socket.addEventListener('close', function (event) {
        console.log('تم إغلاق الاتصال بخادم WebSocket');
    });

    // عند حدوث خطأ
    socket.addEventListener('error', function (event) {
        console.error('حدث خطأ في اتصال WebSocket:', event);
    });

    // دالة لعرض Toast
    function showToast(message) {
        const toastContainer = document.querySelector('.toast-container');
        const toastElement = document.createElement('div');
        toastElement.className = 'toast align-items-center text-bg-primary border-0';
        toastElement.setAttribute('role', 'alert');
        toastElement.setAttribute('aria-live', 'assertive');
        toastElement.setAttribute('aria-atomic', 'true');

        toastElement.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        toastContainer.appendChild(toastElement);
        const toast = new bootstrap.Toast(toastElement);
        toast.show();

        // إزالة الـ Toast بعد انتهاء عرضه
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }
});
