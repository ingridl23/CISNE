"use strict";

document.addEventListener("DOMContentLoaded", () => {
    ["Titulo", "Categoria", "Fecha"].forEach((id) => {
        let input = document.getElementById(id);
        if (!input) return;

        input.addEventListener("keyup", () => filtrarPublicacion(id));
        input.addEventListener("change", () => filtrarPublicacion(id));
        input.addEventListener("blur", () => limpiarContenedor(id));
    });

    let botones = document.querySelectorAll(".botonFiltro");
    botones.forEach((boton) => {
        boton.addEventListener("click", (e) => {
            e.preventDefault();
            let input = boton.previousElementSibling;
            if (input) {
                filtrarPublicacion(input.id);
            }
        });
    });

    function limpiarContenedor(id) {
        if (document.getElementById(id).value === "") {
            fetch("/noticias", { headers: { Accept: "application/json" } })
                .then((res) => res.json())
                .then((data) => showContent(data))
                .catch((err) => console.log(err));
        }
    }

    function filtrarPublicacion(id) {
        let search = document.getElementById(id).value;
        if (search !== "") {
            fetch(`/noticias/buscador${id}?busqueda=${search}`, {
                    method: "GET",
                    headers: { Accept: "application/json" },
                })
                .then((res) => res.json())
                .then((data) => {
                    console.log("Datos recibidos:", data);
                    showContent(data);
                })
                .catch((err) => console.log("Error en fetch:", err));
        } else {
            limpiarContenedor(id);
        }
    }

    function showContent(results) {
        let container = document.getElementById("noticias-container");
        container.innerHTML = "";

        if (!results || results.length === 0) {
            container.innerHTML = `<p>No se encontraron resultados</p>`;
            return;
        }

        results.forEach((noticia) => {
            let card = document.createElement("div");
            card.classList.add("card", "mb-3");
            card.innerHTML = `
                <div class="card-body">
                    <h5>${noticia.titulo}</h5>
                    <p>${noticia.categoria}</p>
                    <small>Publicación: ${noticia.created_at}</small>
                </div>
            `;
            container.appendChild(card);
        });
    }
});
