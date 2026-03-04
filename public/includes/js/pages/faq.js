// simple accordion functionality for FAQ page
window.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.faq-item');
    items.forEach(item => {
        const btn = item.querySelector('.faq-question');
        if (btn) {
            btn.addEventListener('click', () => {
                item.classList.toggle('open');
            });
        }
    });
});