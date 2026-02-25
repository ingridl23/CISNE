"use script"

document.addEventListener("DOMContentLoaded", ()=>{
    if (window.mensajeExito) {
        Swal.fire({
            title: window.mensajeExito.titulo,
            text: window.mensajeExito.detalle,
            icon: "success",
            confirmButtonColor: "#36be7f",
        });
    }


    if (window.mensajeError) {
        Swal.fire({
            title: window.mensajeError.titulo,
            text: window.mensajeError.detalle,
            icon: "error",
            confirmButtonColor: "#36be7f",
        });
    }
})

