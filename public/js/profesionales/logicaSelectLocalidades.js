document.addEventListener("DOMContentLoaded", () => {
    let campoLocalidad = document.querySelector("#localidadesDeLaCiudad");
    let campoCiudad = document.querySelector("#ciudad");
    let labelCiudad = document.querySelector(".direccionEmprendimiento");
    let opcionCargada = document.querySelector(".opcionValorCargado").value;

    if (campoCiudad.value != "") {
        mostrarOpcionesSegunCiudad(campoCiudad.value);
    }

    campoCiudad.addEventListener("change", function () {
        const valor = this.value;
        mostrarOpcionesSegunCiudad(valor);
    });

    function mostrarOpcionesSegunCiudad(valor) {
        document
            .querySelector(".localidadesDeLaCiudad")
            .classList.remove("oculto");
        document
            .querySelector(".localidadesDeLaCiudad")
            .classList.add("mostrar");
        labelCiudad.classList.add("seleccionLocalidad");
        document
            .querySelector(".localidad")
            .classList.add("seleccionLocalidad");
        const TresArroyos = [
            "Tres Arroyos",
            "Claromecó",
            "Orense",
            "Reta",
            "Copetonas",
            "Micaela Cascallares",
            "San Francisco de Bellocq",
            "San Mayol",
            "Lin Calel",
            "Barrow",
        ];
        const AdolfoGonzalesChaves = [
            "Adolfo Gonzales Chaves",
            "De La Garma",
            "Juan Elogio Barra",
        ];
        const BenitoJuarez = [
            "Benito Juarez",
            "Villa Cacique",
            "Barker",
            "Estación López",
            "Tedín Uriburu",
        ];
        switch (valor) {
            case "Tres Arroyos":
                generarOptions(TresArroyos);
                break;
            case "Adolfo Gonzales Chaves":
                generarOptions(AdolfoGonzalesChaves);
                break;
            default:
                generarOptions(BenitoJuarez);
        }
    }

    function generarOptions(TresArroyos) {
        campoLocalidad.innerHTML = "";
        TresArroyos.forEach(function (localidad) {
            let card = document.createElement("option");
            card.selected =
                opcionCargada != undefined && opcionCargada == localidad
                    ? "selected"
                    : "";
            card.innerHTML = `${localidad}`;
            campoLocalidad.appendChild(card);
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const campoCiudad = document.querySelectorAll("#ciudad");
    const campoLocalidad = document.querySelectorAll("#localidad");
    const opcionCargada = document.querySelectorAll(
        ".opcionValorCargado"
    ).value;

    const localidadesPorCiudad = {
        "Tres Arroyos": [
            "Tres Arroyos",
            "Claromecó",
            "Orense",
            "Reta",
            "Copetonas",
            "Micaela Cascallares",
            "San Francisco de Bellocq",
            "San Mayol",
            "Lin Calel",
            "Barrow",
        ],
        "Adolfo Gonzales Chaves": [
            "Adolfo Gonzales Chaves",
            "De La Garma",
            "Juan Elogio Barra",
        ],
        "Benito Juarez": [
            "Benito Juarez",
            "Villa Cacique",
            "Barker",
            "Estación López",
            "Tedín Uriburu",
        ],
    };

    function mostrarLocalidades(ciudad) {
        campoLocalidad.innerHTML =
            '<option value="" disabled selected>Seleccione una localidad</option>';

        if (!localidadesPorCiudad[ciudad]) return;

        localidadesPorCiudad[ciudad].forEach((localidad) => {
            const opt = document.createElement("option");
            opt.value = localidad;
            opt.textContent = localidad;
            if (opcionCargada && localidad === opcionCargada) {
                opt.selected = true;
            }
            campoLocalidad.appendChild(opt);
        });
    }

    // Evento al cambiar ciudad
    campoCiudad.addEventListener("change", function () {
        mostrarLocalidades(this.value);
    });

    // Mostrar localidades si ya hay ciudad cargada
    if (campoCiudad.value) {
        mostrarLocalidades(campoCiudad.value);
    }
});
