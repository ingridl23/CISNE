document.addEventListener("DOMContentLoaded", () => {
    const radios = document.querySelectorAll('input[name="opciones"]');

    function actualizarCampos() {
        const seleccionado = Array.from(radios).find((r) => r.checked);

        // Oculta todos los grupos y quita required a todos los campos internos
        [grupoEmpresa, grupoEmprendedor, grupoDesempleado].forEach((grupo) => {
            grupo.style.display = "none";
            const campos = grupo.querySelectorAll("input, select");
            campos.forEach((campo) => {
                campo.required = false;
            });
        });

        if (!seleccionado) return;

        const valor = seleccionado.value;

        if (valor === "particular") {
            grupoEmpresa.style.display = "block";
            grupoEmpresa.querySelectorAll("input, select").forEach((c) => {
                if (!c.disabled) c.required = true;
            });
        } else if (valor === "institucion") {
            grupoEmprendedor.style.display = "block";
            grupoEmprendedor.querySelectorAll("input, select").forEach((c) => {
                if (!c.disabled) c.required = true;
            });
        } else if (valor === "profesional") {
            grupoDesempleado.style.display = "block";
            grupoDesempleado.querySelectorAll("input, select").forEach((c) => {
                if (!c.disabled) c.required = true;
            });
        }
    }
});

radios.forEach((radio) => radio.addEventListener("change", actualizarCampos));
// Ejecutar al cargar para estado inicial
actualizarCampos();
