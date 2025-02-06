document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.container');
    if (container) {
        container.style.opacity = 0;
        setTimeout(() => {
            container.style.transition = 'opacity 1s ease-in-out';
            container.style.opacity = 1;
        }, 100);
    }
});
