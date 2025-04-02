
const reportesUrl = "http://localhost/registroInasistencias/reporte/";
//let selectFichas = document.querySelector('#selectFichas');
//let selectAprendices = document.querySelector('#selectAprendices');
let btnBuscar = document.querySelector('#btnBuscar');
let inputAprendiz = document.querySelector('#inputAprendiz');
let selectMes = document.querySelector('#selectMes');
let selectFicha2 = document.querySelector('#selectFicha2');

let idAprendizSeleccionado = null;


// ======================================================Listar aprendices en el select,  con la loista desplegable de opciones==================================================
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
                    idAprendizSeleccionado = selected.dataset.id;
                    console.log("ID del aprendiz seleccionado:", selected.dataset.id);
                } else {
                    idAprendizSeleccionado = null;
                }
            });
        });
}

// ===========================================================Listar fichas en el select =======================================================================================
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

//==============================================================optione las asistencias por id del aprendiz ======================================================================

function getAsistenciasForAprendiz(mes, idAprendiz) {
    let añoActual = new Date().getFullYear();
    let fechaInicio = `${añoActual}-${String(mes).padStart(2, '0')}-01 00:00:00`;
    let ultimoDia = new Date(añoActual, mes, 0).getDate();
    let fechaFin = `${añoActual}-${String(mes).padStart(2, '0')}-${ultimoDia} 23:59:59`;

    console.log("Consultando asistencias desde:", fechaInicio, "hasta:", fechaFin, "para el aprendiz:", idAprendiz);

    let url = `${reportesUrl}/getAsistenciasForAprendiz?idAprendiz=${idAprendiz}&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log("Datos:", data);

            let tablaBody = document.querySelector('#tablaReportesBody');


            obtenerDiasDelMes(selectMes.value); // Con esto es para sacar la cabecera segun el mes que elija


            tablaBody.innerHTML = '';

            let fila = document.createElement('tr');

            // Crear un array con celdas vacías para todos los días del mes
            let diasDelMes = new Array(ultimoDia).fill(null);

            data.forEach((reporte) => {

                // Convercion de erro de formato al hacer traer la fecha de la asistencia 

                let fechaParts = reporte.fecha_inasistencia.split(" ")[0].split("-");
                let diaRegistro = parseInt(fechaParts[2], 10);


                let badge = document.createElement('span');

                if (reporte.estado_inasistencia === 'Activo') {
                    badge.classList.add('badge', 'bg-success');
                    badge.textContent = 'Asistió';
                } else {
                    badge.classList.add('badge', 'bg-danger');
                    badge.textContent = 'No Asistió';
                }

                // Guardar el badge en la posición que es, segun el dia 
                diasDelMes[diaRegistro - 1] = badge;
            });

            // Pinta la tabla seguan los dias del mes, y deja en blanco los que no estan registrados aun

            for (let i = 0; i < ultimoDia; i++) {
                let celda = document.createElement('td');
                if (diasDelMes[i]) {
                    celda.appendChild(diasDelMes[i]);
                }
                fila.appendChild(celda);
            }

            tablaBody.appendChild(fila);
        })
        .catch(error => console.error("Error al obtener los reportes:", error));
}




//====================================================Obtiene los dias del mes y los pone en el header de la tabla=================================================

function obtenerDiasDelMes(mes) {
    const diasPorMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    // Verificar si es un año bisiesto para febrero
    const año = new Date().getFullYear();
    if (mes === 2 && ((año % 4 === 0 && año % 100 !== 0) || (año % 400 === 0))) {
        diasPorMes[1] = 29;
    }


    let cabeceraTabla = document.getElementById('cabeceraTabla');
    cabeceraTabla.innerHTML = '';


    // Agregar los días del mes como encabezados de columna

    for (let i = 1; i <= diasPorMes[mes - 1]; i++) {
        let th = document.createElement('th');
        th.textContent = i;
        cabeceraTabla.appendChild(th);
    }
}

let mesActual = new Date().getMonth() + 1;
obtenerDiasDelMes(mesActual);



btnBuscar.addEventListener('click', () => {
    cabeceraTabla.innerHTML = '';

    // ==================================== VALIDACIONES DE NULL O VACIOS PARA LA BUSQUEDA  ==================================

    //  Elimina mensajes de error de antes
    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    selectMes.classList.remove('is-invalid');
    selectFicha2.classList.remove('is-invalid');
    inputAprendiz.classList.remove('is-invalid');

    //  Validar que se seleccione un mes
    if (selectMes.value == '' || selectMes.value == null) {
        selectMes.classList.add('is-invalid');
        const errorMsg = document.createElement('div');
        errorMsg.classList.add('invalid-feedback');
        errorMsg.textContent = 'Por favor, seleccione un mes.';
        selectMes.parentNode.appendChild(errorMsg);
        return;
    }

    //  Validar que se seleccione una ficha o un aprendiz
    if ((selectFicha2.value == '' || selectFicha2.value == null) &&
        (inputAprendiz.value == '' || inputAprendiz.value == null)) {

        // Agregar mensaje en selectFicha2
        selectFicha2.classList.add('is-invalid');
        const errorFicha = document.createElement('div');
        errorFicha.classList.add('invalid-feedback');
        errorFicha.textContent = 'Por favor, seleccione una ficha o un aprendiz.';
        selectFicha2.parentNode.appendChild(errorFicha);

        // Agregar mensaje en inputAprendiz
        inputAprendiz.classList.add('is-invalid');
        const errorAprendiz = document.createElement('div');
        errorAprendiz.classList.add('invalid-feedback');
        errorAprendiz.textContent = 'Por favor, seleccione una ficha o un aprendiz.';
        inputAprendiz.parentNode.appendChild(errorAprendiz);

        return;
    }
    // ============================================================= LLAMO LA FUNCION PARA REALIZAR LA CONSULTA DE BUSQUEDA SEGUN EL APRENDIZ=======================================

    console.log(selectMes.value, idAprendizSeleccionado);
    getAsistenciasForAprendiz(selectMes.value, idAprendizSeleccionado);

});


selectFichas();

selectAprendices();