"use script";

document.addEventListener("DOMContentLoaded", function () {
    let contenedor = document.getElementById("previousImagen");
    let input = document.getElementById("imagen");
    const MAX = 1;
    let dtCopia = new DataTransfer();
    let contenedorLoader = document.querySelector(".contenedor_loader");

    let imagenesTotales = []; //Total de imgs

    document.querySelector(".form").addEventListener("submit", () => {
        contenedorLoader.style.opacity = 1;
        contenedorLoader.style.visibility = "visible";
    });
    //Cuando se decida agregar más imgs
    input.addEventListener("change", () => {
        const nuevosArchivos = Array.from(input.files);
        const espacioDisponible = MAX - imagenesTotales.length;

        if (espacioDisponible <= 0) {
            Swal.fire({
                icon: "error",
                title: "Máximo superado",
                text: `La cantidad de imagenes permitidas es de: ${MAX}`,
                confirmButtonColor: "#36be7f",
            });
            input.files = dtCopia;
            return;
        }
        const archivosPermitidos = nuevosArchivos.slice(0, espacioDisponible);
        archivosPermitidos.forEach((file) => {
            imagenesTotales.push({
                tipo: "nuevo",
                nombre: file.name,
                file: file,
                url: URL.createObjectURL(file),
            });
        });

        input.value = "";
        modificarVista();
    });

    //Para cuando se agrega nuevas imgs y mostrar la vista
    function modificarVista() {
        contenedor.innerHTML = "";

        const dt = new DataTransfer();

        imagenesTotales.forEach((file, index) => {
            const url =
                file.tipo === "nuevo"
                    ? URL.createObjectURL(file.file)
                    : file.url;

            let wrap = document.createElement("div");
            wrap.classList.add("position");
            wrap.dataset.index = index;

            let img = document.createElement("img");
            img.src = url;
            img.alt = file.name;
            img.classList.add("imgEmprendimiento");

            let boton = document.createElement("button");
            boton.type = "button";
            boton.classList.add("cierreEmprendedor");

            let imgCierre = document.createElement("img");
            imgCierre.src = "/assets/img/iconos/close-icon-imgs.png";

            boton.appendChild(imgCierre);

            boton.addEventListener("click", () => {
                imagenesTotales.splice(index, 1);
                modificarVista();
            });

            wrap.appendChild(img);
            wrap.appendChild(boton);
            contenedor.appendChild(wrap);

            if (file.tipo === "nuevo") {
                dt.items.add(file.file);
            }
        });
        input.files = dt.files;
        dtCopia = dt.files;
    }
});
