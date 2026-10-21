import * as bootstrap from 'bootstrap';

document.documentElement.classList.add('js');

document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.site-header');
    const backToTop = document.querySelector('.back-to-top');
    const navCollapse = document.getElementById('siteNavigation');

    const updateChrome = () => {
        if (header) {
            header.classList.toggle('is-scrolled', window.scrollY > 8);
        }

        if (backToTop) {
            backToTop.classList.toggle('is-visible', window.scrollY > 480);
        }
    };

    updateChrome();
    window.addEventListener('scroll', updateChrome, { passive: true });

    backToTop?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    navCollapse?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (navCollapse.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
            }
        });
    });

    const revealItems = document.querySelectorAll('.reveal');

    if (!('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('is-visible'));

        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 },
    );

    revealItems.forEach((item) => observer.observe(item));
});
