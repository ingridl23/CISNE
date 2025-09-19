window.addEventListener("DOMContentLoaded", (event) => {
    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector("#mainNav");
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove("navbar-shrink");
        } else {
            navbarCollapsible.classList.add("navbar-shrink");
        }
    };

    // Shrink the navbar
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener("scroll", navbarShrink);

    //  Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector("#mainNav");
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: "#mainNav",
            rootMargin: "0px 0px -40%",
        });
    }

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector(".navbar-toggler");
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll("#navbarResponsive .nav-link")
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener("click", () => {
            if (window.getComputedStyle(navbarToggler).display !== "none") {
                navbarToggler.click();
            }
        });
    });

    // 2) Formulario de contacto
    const contactForm = document.querySelector("#modal .form");
    const contactSubmit = contactForm.querySelector("#btn");
    const contactError = contactForm.querySelector(".error-msg");
    contactForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const telefono = document.getElementById("telefono").value.trim();
        const email = document.getElementById("email").value.trim();
        const oculto = document.getElementById("oculto").value.trim();

        // restablecer estados
        contactSubmit.classList.remove("click", "error");
        contactError.classList.remove("show");

        // defensa contra bots
        if (oculto !== "") return;

        // validación
        if (!telefono || !email) {
            contactSubmit.classList.add("error");
            contactError.classList.add("show");
        } else {
            contactSubmit.classList.add("click");
            contactSubmit.disabled = true;
            setTimeout(() => {
                contactSubmit.classList.remove("click");
                contactSubmit.disabled = false;
                contactForm.reset();
            }, 2000);
        }
    });

    // 3) Abrir/cerrar modal de contacto
    document.querySelector(".btn-contact").addEventListener("click", (e) => {
        e.preventDefault();
        document.getElementById("modal").classList.add("open");
        document.getElementById("overlay").classList.add("open");
    });
    document.getElementById("closeModal").addEventListener("click", () => {
        document.getElementById("modal").classList.remove("open");
        document.getElementById("overlay").classList.remove("open");
    });
    document.getElementById("overlay").addEventListener("click", () => {
        document.getElementById("modal").classList.remove("open");
        document.getElementById("overlay").classList.remove("open");
    });

    // 4) Formulario de login ADMIN
    const adminForm = document.getElementById("form-admin");
    const adminSubmit = document.getElementById("btn-admin-send");
    const adminError = adminForm.querySelector(".error-msg");
    adminForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const email2 = document.getElementById("email2").value.trim();
        const password = document.getElementById("password").value.trim();
        const oculto2 = document.getElementById("oculto2").value.trim();

        // restablecer estados
        adminSubmit.classList.remove("click", "error");
        adminError.classList.remove("show");

        // defensa contra bots
        if (oculto2 !== "") return;

        // validación
        if (!email2 || !password) {
            adminSubmit.classList.add("error");
            adminError.classList.add("show");
        } else {
            adminSubmit.classList.add("click");
            adminSubmit.disabled = true;
            setTimeout(() => {
                // Dentro del submit de adminForm, cuando sea válido:
                sessionStorage.setItem("isAdmin", "true");

                window.location.href = "indexadmin.html";
            }, 800);
        }
    });

    // 5) Abrir/cerrar modal de admin
    document.querySelector(".btn-admin").addEventListener("click", (e) => {
        e.preventDefault();
        document.getElementById("modal-admin").classList.add("open");
        document.getElementById("overlay-admin").classList.add("open");
    });
    document.getElementById("close-admin").addEventListener("click", () => {
        document.getElementById("modal-admin").classList.remove("open");
        document.getElementById("overlay-admin").classList.remove("open");
    });
    document.getElementById("overlay-admin").addEventListener("click", () => {
        document.getElementById("modal-admin").classList.remove("open");
        document.getElementById("overlay-admin").classList.remove("open");
    });
});
