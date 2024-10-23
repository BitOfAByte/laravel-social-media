document.addEventListener('DOMContentLoaded', function() {
    const notificationBell = document.getElementById('notification-bell');
    const notificationDropdown = document.getElementById('notification-dropdown');
    const notificationList = document.getElementById('notification-list');
    const notificationBadge = document.getElementById('notification-badge');

    // Toggle notification dropdown
    notificationBell.addEventListener('click', function(e) {
        e.stopPropagation();
        notificationDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!notificationDropdown.contains(e.target) && e.target !== notificationBell) {
            notificationDropdown.classList.add('hidden');
        }
    });

    // Handle notification click
    notificationList.addEventListener('click', function(e) {
        const notificationItem = e.target.closest('.notification-item');
        if (notificationItem) {
            const notificationId = notificationItem.dataset.notificationId;
            markNotificationAsRead(notificationId, notificationItem);
        }
    });

    // Mark notification as read
    function markNotificationAsRead(notificationId, notificationItem) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notificationItem.classList.remove('bg-blue-50');
                    updateNotificationBadge();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Update notification badge count
    function updateNotificationBadge() {
        fetch('/notifications/count')
            .then(response => response.json())
            .then(data => {
                if (data.count > 0) {
                    if (!notificationBadge) {
                        const newBadge = document.createElement('span');
                        newBadge.id = 'notification-badge';
                        newBadge.className = 'absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full';
                        newBadge.textContent = data.count;
                        notificationBell.appendChild(newBadge);
                    } else {
                        notificationBadge.textContent = data.count;
                        notificationBadge.classList.remove('hidden');
                    }
                } else if (notificationBadge) {
                    notificationBadge.classList.add('hidden');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Poll for new notifications every 30 seconds
    setInterval(updateNotificationBadge, 30000);
});
