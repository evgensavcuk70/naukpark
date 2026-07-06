// Загальні скрипти сайту (меню, інтерфейс).


document.addEventListener('DOMContentLoaded', function () {

    const header = document.querySelector('.site-header');
    let lastScrollY = window.scrollY;
    let ticking = false;
    const SCROLL_THRESHOLD = 80;

    function handleHeaderScroll() {
        const currentScrollY = window.scrollY;

        if (currentScrollY < SCROLL_THRESHOLD) {

            header.classList.remove('header-hidden', 'header-fixed');
        } else if (currentScrollY > lastScrollY) {

            header.classList.add('header-hidden');
            header.classList.add('header-fixed');
        } else {

            header.classList.remove('header-hidden');
            header.classList.add('header-fixed');
        }

        lastScrollY = currentScrollY;
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            requestAnimationFrame(handleHeaderScroll);
            ticking = true;
        }
    }, { passive: true });


    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.main-nav a[href^="#"]');

    if (sections.length && navLinks.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;
                    navLinks.forEach(link => {
                        link.classList.remove('nav-active');
                        if (link.getAttribute('href') === '#' + id) {
                            link.classList.add('nav-active');
                        }
                    });
                }
            });
        }, {
            rootMargin: '-30% 0px -60% 0px',
            threshold: 0
        });

        sections.forEach(sec => observer.observe(sec));
    }


    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (!target) return;
            e.preventDefault();

            const headerH = header.classList.contains('header-fixed') ? header.offsetHeight : 0;
            const top = target.getBoundingClientRect().top + window.scrollY - headerH - 16;
            window.scrollTo({ top, behavior: 'smooth' });
        });
    });


    const animTargets = document.querySelectorAll(
        '.news-card, .activity-card, .cap-card, .about-text, .about-image'
    );

    if (animTargets.length) {
        animTargets.forEach(el => el.classList.add('reveal'));

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        animTargets.forEach(el => revealObserver.observe(el));
    }


    const progressBar = document.createElement('div');
    progressBar.id = 'read-progress';
    document.body.prepend(progressBar);

    window.addEventListener('scroll', function () {
        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        const scrolled = scrollable > 0 ? (window.scrollY / scrollable) * 100 : 0;
        progressBar.style.width = scrolled + '%';
    }, { passive: true });


    const backToTop = document.createElement('button');
    backToTop.id = 'back-to-top';
    backToTop.setAttribute('aria-label', 'Прокрутити вгору');
    backToTop.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>`;
    document.body.appendChild(backToTop);

    window.addEventListener('scroll', function () {
        if (window.scrollY > 400) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    }, { passive: true });

    backToTop.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });


    const burgerBtn = document.getElementById('burgerBtn');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavClose = document.getElementById('mobileNavClose');

    function openMobileMenu() {
        if (!mobileNav) return;
        mobileNav.classList.add('open');
        if (burgerBtn) { burgerBtn.classList.add('open'); burgerBtn.setAttribute('aria-expanded', 'true'); }
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        if (!mobileNav) return;
        mobileNav.classList.remove('open');
        if (burgerBtn) { burgerBtn.classList.remove('open'); burgerBtn.setAttribute('aria-expanded', 'false'); }
        document.body.style.overflow = '';
    }

    if (burgerBtn) burgerBtn.addEventListener('click', openMobileMenu);
    if (mobileNavClose) {
        mobileNavClose.addEventListener('click', function(e) {
            e.stopPropagation();
            closeMobileMenu();
        });
    }

    // Close on overlay click (but not on nav links)
    if (mobileNav) {
        mobileNav.addEventListener('click', function(e) {
            if (e.target === mobileNav) closeMobileMenu();
        });
    }

    document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMobileMenu();
    });

    // Sync active state in mobile menu
    const mobileSections = document.querySelectorAll('section[id]');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link[href*="#"]');

    if (mobileSections.length && mobileNavLinks.length) {
        const mobileObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;
                    mobileNavLinks.forEach(link => {
                        link.classList.remove('mobile-nav-active');
                        const href = link.getAttribute('href');
                        if (href && href.includes('#' + id)) {
                            link.classList.add('mobile-nav-active');
                        }
                    });
                }
            });
        }, {
            rootMargin: '-30% 0px -60% 0px',
            threshold: 0
        });

        mobileSections.forEach(sec => mobileObserver.observe(sec));
    }


    // Кнопка "Детальніше" на картках напрямків діяльності
    document.querySelectorAll('.activity-card').forEach(function (card) {
        const btn = card.querySelector('.activity-card-toggle');
        if (!btn) return;

        const label = btn.querySelector('.toggle-label');

        btn.addEventListener('click', function () {
            const expanded = card.classList.toggle('expanded');
            btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            if (label) label.textContent = expanded ? btn.dataset.less : btn.dataset.more;
        });
    });

});