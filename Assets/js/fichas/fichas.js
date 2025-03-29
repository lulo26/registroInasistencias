const btnFicha = document.querySelector("#btnFicha");
const numero = document.querySelector("#numero_ficha");
const tablaFichas = document.getElementById("tablaFichas");
const selectCursos = document.getElementById("cursos_idcurso");
const btnCerrar = document.getElementById("btnCerrar");
const btnCerrar2 = document.getElementById("btnCerrar2");
/////////////////////////////////////////////////////LISTAR CURSOS/////////////////////////////////////////////////////
function listarCursos() {
    fetch(base_url + "/fichas/getCursos")
        .then((data) => data.json())
        .then((data) => {
            console.log(data);
            selectCursos.innerHTML = "<option value=''>Seleccione un curso</option>";
            data.forEach((curso) => {
                selectCursos.innerHTML += `<option value="${curso.idcurso}">${curso.nombre_curso}</option>`;
            });
        });
}
/////////////////////////////////////////////////////LIMPIAR FORMULARIO////////////////////////////////////////////////
function limpiarFormulario() {
    frmFichas.reset();
    selectCursos.innerHTML = "<option value=''>Seleccione un curso</option>";
    listarCursos();
}
btnCerrar.addEventListener("click", limpiarFormulario);
btnCerrar2.addEventListener("click", limpiarFormulario);
/////////////////////////////////////////////////////CARGAR FICHAS/////////////////////////////////////////////////////
window.addEventListener("DOMContentLoaded", (e) => {
    listFichas();
    listarCursos();
});
/////////////////////////////////////////////////////ABRIR MODAL/////////////////////////////////////////////////////
btnFicha.addEventListener("click", () => {
    numero.readOnly = false;
    document.getElementById("FichaModalLabel").innerHTML = "Agregar Ficha";
    limpiarFormulario();
    $("#crearFichaModal").modal("show");
});
/////////////////////////////////////////////////////VALIDAR LONGITUD CODIGO/////////////////////////////////////////////
numero.addEventListener("input", function () {
    if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
    }
});
/////////////////////////////////////////////////////ENVIO DE DATOS/////////////////////////////////////////////////////
frmFichas.addEventListener("submit", (e) => {
    e.preventDefault();
    if (selectCursos.value === "") {
        Swal.fire({
            title: "¡Error!",
            text: "Seleccione un curso!.",
            icon: "error",
        });
    } else {
        frmData = new FormData(frmFichas);
        console.log(frmData);
        fetch(base_url + "/fichas/setFichas", {
            method: "POST",
            body: frmData,
        })
            .then((res) => res.json())
            .then((data) => {
                console.log(data);
                Swal.fire({
                    title: data.status ? "¡Correcto!" : "¡Error!",
                    text: data.msg,
                    icon: data.status ? "success" : "error",
                });
                if (data.status) {
                    frmFichas.reset();
                    $("#crearFichaModal").modal("hide");
                    listFichas();
                }
            });
    }
});
/////////////////////////////////////////////////////EDITAR /////// ELIMINAR/////////////////////////////////////////////////////
document.addEventListener("click", (e) => {
    console.log("click");
    try {
        let selected = e.target.closest("button").getAttribute("data-action-type");
        let idficha = e.target.closest("button").getAttribute("rel");
        if (selected == "delete") {
            Swal.fire({
                title: "Eliminar ficha",
                text: "¿Está seguro de eliminar la ficha?",
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Sí",
                denyButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData();
                    formData.append("idficha", idficha);
                    console.log(formData);
                    fetch(base_url + "/fichas/eliminarFicha", {
                        method: "POST",
                        body: formData,
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            Swal.fire({
                                title: data.status ? "¡Correcto!" : "¡Error!",
                                text: data.msg,
                                icon: data.status ? "success" : "error",
                            });
                            listFichas();
                        });
                }
            });
        }
        if (selected == "update") {
            numero.readOnly = true;
            let idficha = e.target.closest("button").getAttribute("rel");
            $("#crearFichaModal").modal("show");
            document.getElementById("FichaModalLabel").innerHTML = "Actualizar Ficha";
            fetch(base_url + `/fichas/getFichaByID/${idficha}`, {
                method: "GET",
            })
                .then((res) => res.json())
                .then((res) => {
                    let ficha = res.data[0];
                    console.log(ficha);
                    document.querySelector("#idficha").value = ficha.idficha;
                    document.querySelector("#numero_ficha").value = ficha.numero_ficha;
                    document.querySelector("#cursos_idcurso").value = ficha.cursos_idcurso;
                    document.querySelector("#fecha_inicio").value = ficha.fecha_inicio;
                    document.querySelector("#fecha_fin").value = ficha.fecha_fin;
                    document.querySelector("#modalidad").value = ficha.modalidad;
                    listarCursos();
                });
        }
    } catch (e) {}
});
/////////////////////////////////////////////////////ASIGNAR USUARIOS/////////////////////////////////////////////////////
// Función para cargar usuarios en el modal
async function cargarUsuariosParaAsignar(idficha) {
    try {
        // Obtener usuarios disponibles
        const response = await fetch(base_url + '/Fichas/getUsuariosParaAsignar');
        const usersData = await response.json();
        
        // Obtener usuarios ya asignados
        const assignedResponse = await fetch(base_url + `/Fichas/getUsuariosAsignados/${idficha}`);
        const assignedData = await assignedResponse.json();
        
        // Llenar select de instructores
        const selectInstructores = document.getElementById('selectInstructores');
        selectInstructores.innerHTML = '';
        usersData.instructores.forEach(instructor => {
            const option = new Option(
                `${instructor.nombre_usuario} (${instructor.numdoc_usuarios})`,
                instructor.idusuario
            );
            selectInstructores.add(option);
            
            // Marcar como seleccionado si ya está asignado
            if (assignedData.status && assignedData.data.some(u => u.usuarios_idusuario == instructor.idusuario)) {
                option.selected = true;
            }
        });
        // Llenar select de aprendices
        const selectAprendices = document.getElementById('selectAprendices');
        selectAprendices.innerHTML = '';
        usersData.aprendices.forEach(aprendiz => {
            const option = new Option(
                `${aprendiz.nombre_usuario} (${aprendiz.numdoc_usuarios})`,
                aprendiz.idusuario
            );
            selectAprendices.add(option);
            // Marcar como seleccionado si ya está asignado
            if (assignedData.status && assignedData.data.some(u => u.usuarios_idusuario == aprendiz.idusuario)) {
                option.selected = true;
            }
        });
        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalAsignarUsuarios'));
        modal.show();
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'No se pudieron cargar los usuarios',
            icon: 'error'
        });
    }
}
// Función para guardar asignaciones
async function guardarAsignaciones() {
    const idficha = document.getElementById('idFichaAsignacion').value;
    const selectInstructores = document.getElementById('selectInstructores');
    const selectAprendices = document.getElementById('selectAprendices');
    const instructores = Array.from(selectInstructores.selectedOptions).map(opt => opt.value);
    const aprendices = Array.from(selectAprendices.selectedOptions).map(opt => opt.value);
    // Validar que solo haya un aprendiz seleccionado
    if (aprendices.length > 1) {
        Swal.fire({
            title: 'Error',
            text: 'Solo puedes seleccionar un aprendiz por ficha',
            icon: 'error'
        });
        return;
    }
    try {
        const response = await fetch(base_url + '/Fichas/gestionarAsignacionUsuarios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                idficha: idficha,
                usuarios: JSON.stringify([...instructores, ...aprendices]),
                accion: 'asignar'
            })
        });
        const result = await response.json();
        if (result.status) {
            Swal.fire({
                title: 'Éxito',
                text: 'Asignaciones guardadas correctamente',
                icon: 'success'
            });
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAsignarUsuarios'));
            modal.hide();
        } else {
            let errorMsg = result.msg || 'Error al guardar las asignaciones';
            if (result.errors) {
                errorMsg += '<br>' + result.errors.join('<br>');
            }
            Swal.fire({
                title: 'Error',
                html: errorMsg,
                icon: 'error'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al conectar con el servidor',
            icon: 'error'
        });
    }
}
// Modificar la función listFichas para incluir el botón de asignar
function listFichas() {
    tablaFichas.innerHTML = "";
    fetch(base_url + "/fichas/getFichas")
        .then((data) => data.json())
        .then((data) => {
            data.forEach((ficha) => {
                tablaFichas.innerHTML += `
                    <tr>
                        <td>${ficha.idficha}</td>
                        <td>${ficha.numero_ficha}</td>
                        <td>${ficha.id_curso}</td>
                        <td>${ficha.fecha_inicio}</td>
                        <td>${ficha.fecha_fin}</td>
                        <td>${ficha.modalidad}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-action-type="update" rel="${ficha.idficha}"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-danger btn-sm" data-action-type="delete" rel="${ficha.idficha}"><i class="bi bi-trash-fill"></i></button>
                            <button class="btn btn-info btn-sm" data-action-type="assign" rel="${ficha.idficha}"><i class="bi bi-people-fill"></i></button>
                        </td>
                    </tr>`;
            });
        });
}
// Manejador de eventos para el botón de asignar
document.addEventListener('click', (e) => {
    if (e.target.closest('button')?.getAttribute('data-action-type') === 'assign') {
        const idficha = e.target.closest('button').getAttribute('rel');
        document.getElementById('idFichaAsignacion').value = idficha;
        cargarUsuariosParaAsignar(idficha);
    }
});
// Manejador de eventos para el botón de guardar asignaciones
document.getElementById('btnGuardarAsignaciones')?.addEventListener('click', guardarAsignaciones);