// notification.js
document.addEventListener('DOMContentLoaded', function() {
    // Initialize notification elements
    const notificationBell = document.getElementById('notification-bell');
    const notificationDropdown = document.getElementById('notification-dropdown');
    const notificationBadge = document.getElementById('notification-badge');
    const notificationList = document.getElementById('notification-list');

    if (notificationBell) {
        // Toggle dropdown visibility
        notificationBell.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');

            // Mark notifications as read when dropdown is opened
            if (!notificationDropdown.classList.contains('hidden')) {
                const unreadNotifications = document.querySelectorAll('.notification-item[data-read-status="unread"]');
                unreadNotifications.forEach(notification => {
                    markNotificationAsRead(notification.dataset.notificationId);
                });
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationDropdown.contains(e.target) && !notificationBell.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });
    }

    // Function to mark notification as read
    function markNotificationAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI to reflect read status
                    const notificationElement = document.querySelector(`.notification-item[data-notification-id="${notificationId}"]`);
                    if (notificationElement) {
                        notificationElement.classList.remove('bg-blue-50');
                        notificationElement.setAttribute('data-read-status', 'read');
                    }

                    // Update notification count
                    updateNotificationCount();
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
    }

    // Function to update notification count
    function updateNotificationCount() {
        fetch('/notifications/count')
            .then(response => response.json())
            .then(data => {
                if (data.count > 0) {
                    notificationBadge.textContent = data.count;
                    notificationBadge.classList.remove('hidden');
                } else {
                    notificationBadge.classList.add('hidden');
                }
            })
            .catch(error => console.error('Error updating notification count:', error));
    }

    // Poll for new notifications every 30 seconds
    setInterval(updateNotificationCount, 30000);
});
