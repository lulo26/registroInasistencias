
const reportesUrl = "http://localhost/registroInasistencias/reporte/";
//let selectFichas = document.querySelector('#selectFichas');
//let selectAprendices = document.querySelector('#selectAprendices');



// Listar aprendices en el select
function selectAprendices() {
    fetch(reportesUrl + "/getAprendices")
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            let listAprendices = document.querySelector('#listAprendices');
            listAprendices.innerHTML = '';

            data.forEach((aprendiz) => {
                let option = document.createElement('option');
                option.value = `${aprendiz.nombre_aprendiz} ${aprendiz.apellido_aprendiz}`;
                option.dataset.id = aprendiz.idaprendiz; // Guarda el ID como atributo 
                listAprendices.appendChild(option);
            });

            // Captura el ID del aprendiz seleccionado
            document.getElementById('inputAprendiz').addEventListener('input', function () {
                let selected = [...listAprendices.options].find(opt => opt.value === this.value);
                if (selected) {
                    console.log("ID del aprendiz seleccionado:", selected.dataset.id);
                }
            });
        });
}

// Listar fichas en el select
function selectFichas() {
    fetch(reportesUrl + "/getFichas")
        .then((data) => data.json())
        .then((data) => {
            console.log(data);
            let selectFicha = document.querySelector('#selectFicha');


            data.forEach((fichas) => {
                selectFicha.innerHTML += `
                  <option value="${fichas.idficha}">${fichas.numero_ficha}</option>`;
            });
        });
}
selectFichas();

selectAprendices();