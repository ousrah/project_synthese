/**
 * ===================================================================
 * SCRIPTS INTERACTIFS DU COURS
 * ===================================================================
 * 
 * - Bouton Copier pour les blocs de code
 * - Toggle pour afficher/masquer les solutions
 * - Navigation flottante
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

    // === TOGGLE SOLUTION ===
    document.querySelectorAll('.solution-toggle').forEach(button => {
        button.addEventListener('click', function () {
            const solutionContent = this.nextElementSibling;

            if (solutionContent.style.display === 'block') {
                solutionContent.style.display = 'none';
                this.innerText = '👁️ Voir la solution';
                this.style.backgroundColor = '#3b82f6';
            } else {
                solutionContent.style.display = 'block';
                this.innerText = '🙈 Masquer la solution';
                this.style.backgroundColor = '#6b7280';
            }
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
            });
        });
    }
});

// === FONCTION UTILITAIRE POUR IMPRIMER UNE SECTION ===
function printSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (!section) return;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Impression - ${document.title}</title>
            <link href="style.css" rel="stylesheet">
            <style>
                body { padding: 2rem; }
                .copy-btn, .solution-toggle, .chapter-nav { display: none !important; }
                .solution-content { display: block !important; }
            </style>
        </head>
        <body>${section.innerHTML}</body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
