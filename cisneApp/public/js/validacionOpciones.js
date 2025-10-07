document.addEventListener("DOMContentLoaded", () => {
    const radios = document.querySelectorAll('input[name="opciones"]');

    // Oculta el campo de CV al cargar
    campoCV.style.display = "none";

    radios.forEach((radio) => {
        radio.addEventListener("change", () => {
            if (radio.value === "profesional") {
                campoCV.style.display = "block";
                document.getElementById("cv").required = true;
            } else {
                campoCV.style.display = "none";
                document.getElementById("cv").required = false;
            }
        });
    });
});
