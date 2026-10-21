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

    const closeNavigation = () => {
        if (navCollapse?.classList.contains('show')) {
            bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
        }
    };

    const isNavigationLink = (link) => navCollapse?.contains(link) === true;

    navCollapse?.querySelectorAll('a:not([href^="#"])').forEach((link) => {
        link.addEventListener('click', closeNavigation);
    });

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    document.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const hash = link.getAttribute('href');

            if (!hash || hash === '#' || event.defaultPrevented || event.button !== 0
                || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                return;
            }

            const target = document.getElementById(hash.slice(1));

            if (!target) {
                return;
            }

            event.preventDefault();

            const scrollToTarget = () => {
                target.scrollIntoView({
                    behavior: prefersReducedMotion.matches ? 'auto' : 'smooth',
                    block: 'start',
                });

                if (window.location.hash !== hash) {
                    history.pushState(null, '', hash);
                }
            };

            if (isNavigationLink(link) && navCollapse.classList.contains('show')) {
                navCollapse.addEventListener('hidden.bs.collapse', scrollToTarget, { once: true });
                closeNavigation();

                return;
            }

            scrollToTarget();
        });
    });

    const navSections = [...document.querySelectorAll('.site-nav [data-nav-anchor]')]
        .map((link) => ({ link, section: document.getElementById(link.dataset.navAnchor.slice(1)) }))
        .filter(({ section }) => section !== null);

    const updateActiveNavigation = () => {
        if (navSections.length === 0) {
            return;
        }

        const headerOffset = (header?.offsetHeight ?? 0) + 1;
        let activeSection = navSections[0].section;

        navSections.forEach(({ section }) => {
            if (section.getBoundingClientRect().top <= headerOffset) {
                activeSection = section;
            }
        });

        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2) {
            activeSection = navSections[navSections.length - 1].section;
        }

        navSections.forEach(({ link, section }) => {
            const isActive = section === activeSection;

            link.classList.toggle('active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    };

    updateActiveNavigation();
    window.addEventListener('scroll', updateActiveNavigation, { passive: true });
    window.addEventListener('resize', updateActiveNavigation);

    document.querySelectorAll('[data-project-filter]').forEach((root) => {
        const grid = root.querySelector('[data-project-grid]');
        const emptyState = root.querySelector('[data-project-empty]');
        const pills = [...root.querySelectorAll('[data-project-filter-value]')];

        if (!grid || pills.length === 0) {
            return;
        }

        const cards = [...grid.querySelectorAll('[data-project-card]')];
        let switchTimer;

        const animateCardsIn = (visibleCards) => {
            if (prefersReducedMotion.matches) {
                return;
            }

            visibleCards.forEach((card, index) => {
                card.classList.add('is-visible');
                card.getAnimations().forEach((animation) => animation.cancel());

                if (typeof card.animate !== 'function') {
                    return;
                }

                card.animate(
                    [
                        { opacity: 0, transform: 'translateY(18px) scale(0.98)' },
                        { opacity: 1, transform: 'none' },
                    ],
                    {
                        duration: 440,
                        delay: index * 60,
                        easing: 'cubic-bezier(0.22, 1, 0.36, 1)',
                        fill: 'backwards',
                    },
                );
            });
        };

        const applyFilter = (value, pill) => {
            const visibleCards = cards.filter(
                (card) => !value || card.dataset.projectCategory === value,
            );

            window.clearTimeout(switchTimer);
            grid.classList.add('is-switching');

            if (!prefersReducedMotion.matches && typeof pill.animate === 'function') {
                pill.animate(
                    [
                        { transform: 'scale(0.94)' },
                        { transform: 'scale(1.05)' },
                        { transform: 'scale(1)' },
                    ],
                    { duration: 300, easing: 'cubic-bezier(0.22, 1, 0.36, 1)' },
                );
            }

            switchTimer = window.setTimeout(() => {
                const visibleSet = new Set(visibleCards);

                cards.forEach((card) => {
                    card.hidden = !visibleSet.has(card);
                });

                if (emptyState) {
                    emptyState.hidden = visibleCards.length > 0;
                }

                grid.classList.remove('is-switching');
                animateCardsIn(visibleCards);
            }, prefersReducedMotion.matches ? 0 : 150);
        };

        pills.forEach((pill) => {
            pill.addEventListener('click', () => {
                if (pill.classList.contains('is-active')) {
                    return;
                }

                pills.forEach((candidate) => {
                    const isActive = candidate === pill;
                    candidate.classList.toggle('is-active', isActive);
                    candidate.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });

                applyFilter(pill.dataset.projectFilterValue ?? '', pill);
            });
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
