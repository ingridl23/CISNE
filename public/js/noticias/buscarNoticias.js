"use scrict"
document.addEventListener('DOMContentLoaded', e=>{
    /*document.getElementById('filterTitulo').addEventListener("keyup", filtrarEmprendedor);
    document.getElementById('filterTitulo').addEventListener("blur", limpiarContenedor);
    document.querySelector(".botonFiltro").addEventListener("click", function(e) {
        e.preventDefault();
    });
    let admin=false;
    */
    let busqueda=null;
    let inputs=document.querySelectorAll(".inputFiltrosNoticias");
    inputs.forEach(input => {
        busqueda=input.id;
        input.addEventListener("keyup", function(){
            filtrarEmprendedor(this.id);
        });
        input.addEventListener("change", function(){
            filtrarEmprendedor(this.id);
        });
        input.addEventListener("blur", function(){
            limpiarContenedor(this.id);
        });

    });

    let botones=document.querySelectorAll(".botonFiltro");
    botones.forEach(boton=>{
        boton.addEventListener("click", function(e) {
            let input=boton.previousElementSibling;
            let id=input.id;
            filtrarEmprendedor(id)
            e.preventDefault();
        });
    });
    

    function limpiarContenedor(id){
        if(document.getElementById(`${id}`).value==""){
            let container = document.getElementById("noticias-container");
            container.innerHTML = "";
        }
    }


    function filtrarEmprendedor(id){
        if(document.getElementById(`${id}`).value!=""){
            let search = document.getElementById(`${id}`).value;
            fetch(`noticias/buscador${id}?busqueda=${search}`, {
                method: 'get'
            })
            .then(response => response.json())
            .then(data => {
                showContent(data);
            })
            .catch(error => console.log(error))
        }
        else{
            let container = document.getElementById("noticias-container");
            container.innerHTML = "";
        }
    }

    
     function showContent(results){
        let container = document.getElementById("noticias-container");
        container.innerHTML = "";
        if(results.length === 0){
              container.innerHTML += `<p> No se encontraron resultados</p>`;
        }
        results.forEach(noticia =>{
            let fechaCreado = new Date(noticia.created_at);
            let soloFechaCreado = fechaCreado.toISOString().split('T')[0];
            let fechaActualizado = new Date(noticia.updated_at);
            let soloFechaActualizado = fechaActualizado.toISOString().split('T')[0];
            let card = document.createElement('div');
            let contenido = `
                <div class="card mb-3">
                    <img src="${noticia.imagen}" class="card-img-top1"
                        alt="...">
                    <div class="card-body">
                        <h5 class="card-title">${noticia.titulo}</h5>
                        <p class="card-text">${noticia.categoria}</p>
                        <div class="container-vermas">
                            <p class="card-text actualizacionFecha"><small class="text-body-secondary">Publicación : ${soloFechaCreado}</small></p>
                            <p class="card-text actualizacionFecha"><small class="text-body-secondary">Última actualización: ${soloFechaActualizado}</small></p>
                            <a href="/noticias/${noticia.id}">
                                <button class="vermas">Ver más</button>
                            </a>
                        </div>
                    </div>
                </div>`;
            card.innerHTML=contenido;
            container.appendChild(card);
                
        });
        let linea = document.createElement('hr');

        container.appendChild(linea);
    }

})