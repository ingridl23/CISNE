"use script";

document.addEventListener("DOMContentLoaded", () => {
    let formEditar = document.querySelector("#editarForm");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let contenedor = document.getElementById("previousImagen");
    let mostrarElems = contenedor.dataset.mostrar == "true";
    let input = document.getElementById("imagen");
    const MAX = 1;
    let dtCopia = new DataTransfer();
    let contenedorLoader = document.querySelector(".contenedor_loader");

    let imagenesTotales = []; //Total de imgs (tanto backend como las que se cargan)
    const imagenesJSON = JSON.parse(contenedor.dataset.array || "[]"); // array de imágenes existentes desde el backend (editar emprendimiento)
    if (mostrarElems) {
        imagenesTotales.push({
            tipo: "precargada",
            url: imagenesJSON.url,
            public_id: imagenesJSON.public_id,
        });
    }

    document.querySelector(".form").addEventListener("submit", () => {
        contenedorLoader.style.opacity = 1;
        contenedorLoader.style.visibility = "visible";
    });

    formEditar.addEventListener("submit", (e) => {
        e.preventDefault();
        let id = formEditar.dataset.id;
        let formData = new FormData();

        input.files = dtCopia;

        if (imagenesTotales.length > 0) {
            let file = imagenesTotales[0];
            formData.append("imagen", file.file); // archivos reales
            //Sirve para visualizar en consola los datos guardados en formData
            /*for (let [key, value] of formData.entries()) {
                console.log(`${key}:`, value instanceof File ? value.name : value);
            }*/
            fetch(`/noticias/editarImgs/${id}`, {
                method: "post",
                body: formData,
                headers: { "X-CSRF-TOKEN": csrfToken },
            })
                .then(async (response) => {
                    const data = await response.json();
                    if (!response.ok) {
                        const redirectUrl =
                            data.redirect +
                            "?status=" +
                            encodeURIComponent(data.status) +
                            "&message=" +
                            encodeURIComponent(JSON.stringify(data.message));
                        window.location.href = redirectUrl;
                        return;
                    }
                    return data;
                })
                .then((data) => {
                    console.log(data);
                    document.querySelector("#editarForm").submit();
                })
                .catch((error) => console.log(error));
        } else {
            Swal.fire({
                title: "Error",
                text: "Se necesita tener cargado una imagen de la noticia.",
                icon: "error",
                confirmButtonColor: "#36be7f",
            });
        }
    });

    // Mostrar al iniciar
    modificarVista();

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
        let file = imagenesTotales[0];
        if (file != undefined) {
            const url =
                file.tipo === "nuevo"
                    ? URL.createObjectURL(file.file)
                    : file.url;
            let wrap = document.createElement("div");
            wrap.classList.add("position");
            wrap.dataset.index = 0;

            let img = document.createElement("img");
            img.src = url;
            img.classList.add("imgEmprendimiento");

            let boton = document.createElement("button");
            boton.type = "button";
            boton.classList.add("cierreEmprendedor");

            let imgCierre = document.createElement("img");
            imgCierre.src = "/assets/img/iconos/close-icon-imgs.png";

            boton.appendChild(imgCierre);

            boton.addEventListener("click", () => {
                imagenesTotales.splice(0, 1);
                modificarVista();
            });

            wrap.appendChild(img);
            wrap.appendChild(boton);
            contenedor.appendChild(wrap);

            if (file.tipo === "nuevo") {
                dt.items.add(file.file);
            }
        }
        input.files = dt.files;
        dtCopia = dt.files;
    }
});
