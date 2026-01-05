/**
 * ===================================================================
 * SCRIPTS INTERACTIFS DU COURS
 * ===================================================================
 */

document.addEventListener('DOMContentLoaded', function () {

    // === BOUTON COPIER CODE ===
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function () {
            const wrapper = this.closest('.code-block-wrapper');
            const codeBlock = wrapper.querySelector('.code-block');
            const code = codeBlock.innerText;

            navigator.clipboard.writeText(code).then(() => {
                const originalText = this.innerText;
                this.innerText = '✓ Copié !';
                this.classList.add('copied');

                setTimeout(() => {
                    this.innerText = originalText;
                    this.classList.remove('copied');
                }, 2000);
            }).catch(err => {
                console.error('Erreur de copie : ', err);
                this.innerText = 'Erreur';
                setTimeout(() => {
                    this.innerText = 'Copier';
                }, 2000);
            });
        });
    });

    // === SMOOTH SCROLL POUR LES ANCRES ===
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // === PROGRESSION DE LECTURE ===
    const progressBar = document.getElementById('reading-progress');
    if (progressBar) {
        window.addEventListener('scroll', function () {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            progressBar.style.width = progress + '%';
        });
    }

    // === HIGHLIGHT SECTION ACTIVE DANS LE SOMMAIRE ===
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.toc-link');

    if (sections.length > 0 && navLinks.length > 0) {
        window.addEventListener('scroll', function () {
            let current = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;

                if (window.scrollY >= sectionTop - 150) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
                // Also handle classes for floating aside menu
                if (link.parentElement.classList.contains('hover:text-blue-600')) {
                    // This is for the top grid links
                }
            });

            // Special color for floating menu active links
            document.querySelectorAll('.chapter-nav .toc-link').forEach(link => {
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('bg-blue-100', 'text-blue-700', 'font-bold');
                } else {
                    link.classList.remove('bg-blue-100', 'text-blue-700', 'font-bold');
                }
            });
        });
    }
});
