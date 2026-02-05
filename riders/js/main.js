// Mobile Menu Toggle
const menuBtn = document.querySelector(".menu-btn");
const navLinks = document.querySelector(".nav-links");

if (menuBtn) {
    menuBtn.addEventListener("click", () => {
        navLinks.classList.toggle("active");
    });
}

// Scroll Reveal
const revealElements = document.querySelectorAll(".reveal");

window.addEventListener("scroll", () => {
    revealElements.forEach(el => {
        const top = el.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (top < windowHeight - 100) {
            el.classList.add("visible");
        }
    });
});

