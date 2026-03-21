window.addEventListener("DOMContentLoaded", (event) => {
    // Navbar shrink function
    var navbarShrink = function() {
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
    responsiveNavItems.map(function(responsiveNavItem) {
        responsiveNavItem.addEventListener("click", () => {
            if (window.getComputedStyle(navbarToggler).display !== "none") {
                navbarToggler.click();
            }
        });
    });

    // =================================================================
    // 2) FORMULARIO DE CONTACTO
    // =================================================================
    const contactForm = document.querySelector("#modal .form");
    if (contactForm) {
        const contactSubmit = contactForm.querySelector("#btn");
        const contactError = contactForm.querySelector(".error-msg");

        contactForm.addEventListener("submit", (e) => {

            const telefono = document.getElementById("telefono").value.trim();
            const email = document.getElementById("email").value.trim();
            const oculto = document.getElementById("oculto").value.trim();

            // Restablecer estados
            contactSubmit.classList.remove("click", "error");
            if (contactError) contactError.classList.remove("show");


            // defensa contra bots
            if (oculto !== "") {
                e.preventDefault();
                return;
            }
            // validación
            if (!telefono || !email) {
                e.preventDefault(); // solo bloquea si hay error
                contactSubmit.classList.add("error");
                if (contactError) contactError.classList.add("show");
                return;
            }

            // animación del botón
            contactSubmit.classList.add("click");
            contactSubmit.disabled = true;


        });
    }


    // =================================================================
    // 3) ABRIR/CERRAR MODAL DE CONTACTO
    // =================================================================
    const btnContact = document.querySelector(".btn-contact");
    const modalContact = document.getElementById("modal");
    const overlayContact = document.getElementById("overlay");
    const closeModalBtn = document.getElementById("closeModal");

    if (btnContact && modalContact && overlayContact) {
        btnContact.addEventListener("click", (e) => {
            e.preventDefault();
            modalContact.classList.add("open");
            overlayContact.classList.add("open");
        });

        if (closeModalBtn) {
            closeModalBtn.addEventListener("click", () => {
                modalContact.classList.remove("open");
                overlayContact.classList.remove("open");
            });
        }

        overlayContact.addEventListener("click", () => {
            modalContact.classList.remove("open");
            overlayContact.classList.remove("open");
        });
    }

    // =================================================================
    // 4) FORMULARIO DE LOGIN ADMIN - INTEGRADO CON LARAVEL
    // =================================================================
    const adminForm = document.getElementById("form-admin");
    const adminSubmit = document.getElementById("btn-admin-send");
    const modalAdmin = document.getElementById("modal-admin");
    const overlayAdmin = document.getElementById("overlay-admin");

    if (adminForm && adminSubmit) {
        adminForm.addEventListener("submit", (e) => {
            const email2 = document.getElementById("email2").value.trim();
            const password = document.getElementById("contraseña").value.trim();
            const oculto2 = document.getElementById("oculto2").value.trim();

            // Defensa contra bots - prevenir envío si campo oculto tiene valor
            if (oculto2 !== "") {
                e.preventDefault();
                return false;
            }

            // Validación básica del lado del cliente
            if (!email2 || !password) {
                e.preventDefault();
                adminSubmit.classList.add("error");

                // Mostrar mensaje de error si existe
                const adminError = adminForm.querySelector(".error-msg");
                if (adminError) {
                    adminError.textContent = "Complete todos los campos";
                    adminError.classList.add("show");
                }
                return false;
            }

            //  Si pasa las validaciones, dejar que Laravel procese el form
            // Mostrar loading en el botón
            adminSubmit.classList.add("click");
            adminSubmit.disabled = true;

            // El form se enviará normalmente a Laravel
            // Laravel redirigirá o devolverá errores según corresponda
        });
    }

    // =================================================================
    // 5) ABRIR/CERRAR MODAL DE ADMIN
    // =================================================================
    const btnAdmin = document.querySelector(".btn-admin");
    const closeAdminBtn = document.getElementById("close-admin");

    // Abrir modal admin cuando se hace clic en el botón
    if (btnAdmin && modalAdmin && overlayAdmin) {
        btnAdmin.addEventListener("click", (e) => {
            e.preventDefault();
            modalAdmin.classList.add("open");
            overlayAdmin.classList.add("open");
            document.body.style.overflow = "hidden";
        });
    }

    // Cerrar modal admin
    function closeAdminModal() {
        if (modalAdmin && overlayAdmin) {
            modalAdmin.classList.remove("open");
            overlayAdmin.classList.remove("open");
            document.body.style.overflow = "";
        }
    }

    if (closeAdminBtn) {
        closeAdminBtn.addEventListener("click", closeAdminModal);
    }

    if (overlayAdmin) {
        overlayAdmin.addEventListener("click", closeAdminModal);
    }

    // =================================================================
    // 6) ABRIR MODAL AUTOMÁTICAMENTE SI HAY ERRORES DE VALIDACIÓN
    // =================================================================
    // Verificar si hay errores de Laravel en el modal admin
    if (modalAdmin && overlayAdmin) {
        const hasErrors = modalAdmin.querySelector(".alert-danger");
        if (hasErrors) {
            // Abrir modal automáticamente si hay errores
            modalAdmin.classList.add("open");
            overlayAdmin.classList.add("open");
            document.body.style.overflow = "hidden";
        }
    }
    const mensajeExito = document.getElementById("mensaje-exito");

    if (mensajeExito) {
        // hacerlo visible sí o sí
        mensajeExito.style.display = "block";
        mensajeExito.style.opacity = "1";

        // opcional: scroll automático
        mensajeExito.scrollIntoView({ behavior: "smooth" });

        // ocultar después de 4s
        setTimeout(() => {
            mensajeExito.style.transition = "opacity 0.5s";
            mensajeExito.style.opacity = "0";
        }, 4000);
    }
    // =================================================================
    // 7) MENSAJES DE ÉXITO/ERROR - AUTO CERRAR
    // =================================================================
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
        if (alert.classList.contains("alert-success")) {
            setTimeout(() => {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        }
    });
});