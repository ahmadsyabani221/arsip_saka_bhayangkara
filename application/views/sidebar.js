// sidebar.js
document.addEventListener('DOMContentLoaded', function () {
    const burger = document.getElementById('burger');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');

    burger.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        content.classList.toggle('show');
        burger.classList.toggle('show');
    });
});
