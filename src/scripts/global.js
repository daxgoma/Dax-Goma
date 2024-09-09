document.addEventListener('DOMContentLoaded', function() {
    menuBtn = document.getElementById("menuBtn");
    closeMenuBtn = document.getElementById("closeMenuBtn");
    menu = document.getElementById("menu");

    menuBtn.addEventListener('click', function() {
        menu.style.right = 0;
        document.body.style.overflow = 'hidden';
    });

    closeMenuBtn.addEventListener('click', function() {
        menu.style.right = '-100%';
        document.body.style.overflow = 'auto';
    });

});

