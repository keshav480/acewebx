// sticky header shadow on scroll
document.addEventListener('scroll', () => {
    const header = document.getElementById('site-header');
    if (!header) return;

    if (window.scrollY > 20) {
        header.classList.add('shadow-lg');
    } else {
        header.classList.remove('shadow-lg');
    }
});