document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".cerrado-checkbox");
    checkboxes.forEach((chk) => {
        chk.addEventListener("change", function () {
            const dia = this.dataset.dia;
            const apertura = document.querySelector(
                `[name="horarios[${dia}][hora_de_apertura]"]`
            );
            const cierre = document.querySelector(
                `[name="horarios[${dia}][hora_de_cierre]"]`
            );
            if (this.checked) {
                apertura.disabled = true;
                cierre.disabled = true;
            } else {
                apertura.disabled = false;
                cierre.disabled = false;
            }
        });

        // Ejecutar al cargar (por si ya está marcado)
        chk.dispatchEvent(new Event("change"));
    });
});
