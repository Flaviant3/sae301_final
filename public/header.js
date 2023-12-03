document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('menu-btn');
    const navList = document.getElementById('nav-list');
    const nav = document.querySelector('.nav');

    // Gestionnaire d'événements pour le bouton hamburger
    menuBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        navList.classList.toggle('show');
        nav.classList.toggle('expanded');
    });

    // Gestionnaire d'événements pour détecter les clics à l'extérieur du menu
    document.addEventListener('click', function (event) {
        const isClickInsideMenu = nav.contains(event.target) || navList.contains(event.target);
        const isClickOnMenuBtn = menuBtn.contains(event.target);

        if (!isClickInsideMenu && !isClickOnMenuBtn && navList.classList.contains('show')) {
            navList.classList.remove('show');
            nav.classList.remove('expanded');
        }
    });

    // Gestionnaire d'événements pour détecter les clics sur la navigation elle-même
    nav.addEventListener('click', function () {
        if (navList.classList.contains('show')) {
            navList.classList.remove('show');
            nav.classList.remove('expanded');
        } else {
            navList.classList.add('show');
            nav.classList.add('expanded');
        }
    });
});
