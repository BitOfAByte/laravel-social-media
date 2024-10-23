document.addEventListener('DOMContentLoaded', function () {
    const bell = document.getElementById('notification-bell');
    const dropdown = document.getElementById('notification-dropdown');

    bell.addEventListener('click', function () {
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function (event) {
        if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
});
