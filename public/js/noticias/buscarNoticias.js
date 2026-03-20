"use scrict"
document.addEventListener('DOMContentLoaded', e => {

    let busqueda = null;
    let inputs = document.querySelectorAll(".inputFiltrosNoticias");

    let timeout = null;

    inputs.addEventListener("keyup", function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            filtrarNoticia(this.id);
        }, 400);
    });


    inputs.forEach(input => {
        busqueda = input.id;
        if (input.type !== "date") {
            input.addEventListener("keyup", function() {
                filtrarNoticia(this.id);
            });
        }
        input.addEventListener("change", function() {
            filtrarNoticia(this.id);
        });
        input.addEventListener("blur", function() {
            limpiarContenedor(this.id);
        });

    });

    let botones = document.querySelectorAll(".botonFiltro");
    botones.forEach(boton => {
        boton.addEventListener("click", function(e) {
            let input = boton.previousElementSibling;
            let id = input.id;
            filtrarNoticia(id)
            e.preventDefault();
        });
    });


    function limpiarContenedor(id) {
        if (document.getElementById(`${id}`).value == "") {
            let container = document.getElementById("noticias-container");
            container.innerHTML = "";
        }
    }

    function filtrarNoticia(id) {
        let input = document.getElementById(id);

        if (input.value !== "") {
            let search = input.value;

            if (search.length < 2 && id !== "Fecha") return;

            let rutas = {
                Titulo: "/noticias/buscadorTitulo",
                Categoria: "/noticias/buscadorCategoria",
                Fecha: "/noticias/buscadorFecha"
            };

            let url = rutas[id] + "?busqueda=" + search;

            fetch(url, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Error en servidor");
                    }
                    return response.text();
                })
                .then(text => {
                    console.log("RESPUESTA CRUDA:", text);

                    // si viene vacío → tratarlo como array vacío
                    if (!text || text.trim() === "") {
                        showContent([]);
                        return;
                    }

                    let data = JSON.parse(text);

                    showContent(data);
                })
                .catch(error => console.log("ERROR:", error));

        }
    }

    function showContent(results) {
        let container = document.getElementById("noticias-container");
        container.innerHTML = "";
        if (results.length === 0) {
            container.innerHTML += `<p> No se encontraron resultados</p>`;
        }
        results.forEach(noticia => {
            let fechaCreado = new Date(noticia.created_at);
            let soloFechaCreado = fechaCreado.toISOString().split('T')[0];
            let fechaActualizado = new Date(noticia.updated_at);
            let soloFechaActualizado = fechaActualizado.toISOString().split('T')[0];
            let card = document.createElement('div');
            card.classList.add("row")
            card.classList.add("container-card")
            let contenido = `
                <div class="card mb-3">
                    <img src="${noticia.imagen}" class="card-img-top1"
                        alt="...">
                    <div class="card-body">
                        <h5 class="card-title">${noticia.titulo}</h5>
                        <p class="card-text">Categoría ID: ${noticia.categoria}</p>
                        <div class="container-vermas">
                            <p class="card-text actualizacionFecha"><small class="text-body-secondary">Publicación : ${soloFechaCreado}</small></p>
                            <p class="card-text actualizacionFecha"><small class="text-body-secondary">Última actualización: ${soloFechaActualizado}</small></p>
                            <button class="vermas"><a href="noticias/${noticia.id}">Ver más</a></button>
                        </div>
                    </div>
                </div>`;
            card.innerHTML = contenido;
            container.appendChild(card);

        });
        let linea = document.createElement('hr');

        container.appendChild(linea);
    }

})