document.addEventListener("DOMContentLoaded", () => {
    const campoProvincia = document.querySelector("#provincia");
    const nodo = document.querySelector(".opcionValorCargado");
    const opcionCargada = nodo ? nodo.value : undefined;

    const provincias = [
        "Buenos Aires",
        "Catamarca",
        "Chaco",
        "Chubut",
        "Córdoba",
        "Corrientes",
        "Entre Ríos",
        "Formosa",
        "Jujuy",
        "La Pampa",
        "La Rioja",
        "Mendoza",
        "Misiones",
        "Neuquén",
        "Río Negro",
        "Salta",
        "San Juan",
        "San Luis",
        "Santa Cruz",
        "Santa Fe",
        "Santiago del Estero",
        "Tierra del Fuego",
        "Tucumán",
    ];

    // Limpiar opciones previas
    campoProvincia.innerHTML =
        '<option value="" disabled selected>Seleccionar provincia...</option>';

    // Cargar provincias dinámicamente
    provincias.forEach((prov) => {
        let option = document.createElement("option");
        option.value = prov;
        option.textContent = prov;

        // Si es edición → dejar seleccionada
        if (opcionCargada && opcionCargada === prov) {
            option.selected = true;
        }

        campoProvincia.appendChild(option);
    });
});
