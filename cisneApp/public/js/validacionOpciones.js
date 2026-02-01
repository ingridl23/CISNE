document.addEventListener("DOMContentLoaded", () => {
    const radios = document.querySelectorAll('input[name="opciones"]');
    const campoCV = document.querySelector(".campoCV"); // <--- SELECCIONA EL DIV
    const inputCV = document.getElementById("cv");

    // Ocultar el campo CV al inicio
    campoCV.style.display = "none";

    radios.forEach((radio) => {
        radio.addEventListener("change", () => {
            if (radio.value === "profesional") {
                campoCV.style.display = "block";
                inputCV.required = true;
            } else {
                campoCV.style.display = "none";
                inputCV.required = false;
            }
        });
    });
});