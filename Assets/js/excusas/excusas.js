/* const btnUsuario = document.querySelector("#btnUsuario");
let frmUsuarios = document.querySelector("#frmUsuarios"); */

let idexcusa = document.querySelector("#idexcusa");
let idAprendiz = document.querySelector("#idAprendiz");
let idInasistencia = document.querySelector("#idInasistencia");

const btnCerrar = document.getElementById("btnCerrar");
const btnEquis = document.getElementById("btnEquis");
const tablaInasistencias = document.getElementById("tablaInasistencias");

const tablaExcusas = document.getElementById("tablaExcusas");

////////////////////////////////////////////////
// -------------- LISTAR EXCUSAS ---------------
////////////////////////////////////////////////

function listExcusas() {
  tablaExcusas.innerHTML = "";
  let idInstructor = 11;
  /* fetch(base_url + `/excusas/getExcusasPorInstructor/${idusuario}`, {
    method: "GET",
  }) */
  fetch(base_url + `/excusas/getExcusasPorInstructor/${idInstructor}`, {
    method: "GET",
  })
    .then((data) => data.json())
    .then((data) => {
      /* 
      console.log(data); */
      data.forEach((excusa) => {
        /* 
        console.log(excusa.nombre_aprendiz); */
        tablaExcusas.innerHTML += `
                <td>${excusa.fecha_excusa}</td>
                <td>${excusa.nombre_aprendiz}</td>
                <td>${excusa.nombre_curso}</td>
                <td>${excusa.numero_ficha}</td>
                <td>${excusa.fecha_inasistencia}</td>
                <td>${excusa.estado_excusa}</td>
                <td>${excusa.excusa}</td>
                <td>${excusa.options}</td>`;
      });
    });
}

/////////////////////////////////////////////////////////////////
// -------------- MOSTRAR/APROBAR/RECHAZAR EXCUSA ---------------
/////////////////////////////////////////////////////////////////
document.addEventListener("click", (e) => {
  try {
    let selected = e.target.closest("button").getAttribute("data-action-type");
    let idexcusa = e.target.closest("button").getAttribute("rel");

    if (selected == "descargar") {
      /* console.log(idexcusa); */
      fetch(base_url + `/excusas/mostrarExcusaDescargaDirecta?idexcusa=${idexcusa}`, {
        method: "GET",
      })
        .then((data) => data.blob())
        .then((excusa) => {
          const link = document.createElement("a"); // Crea un enlace de descarga
          fileURL = URL.createObjectURL(excusa); // Crea una URL temporal para el archivo
          window.open(fileURL, "_blank");
          /* link.download = "archivo.pdf"; */ // Asigna un nombre al archivo descargado
          link.click(); // Simula el clic para que el archivo se descargue
        });
    }

    if (selected == "aprobar") {
      Swal.fire({
        title: "Aprobar excusa",
        text: "¿Desea aprobar esta excusa?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Sí",
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData();
          formData.append("idexcusa", idexcusa);
          /* console.log(formData); */
          fetch(base_url + "/excusas/aprobarExcusa", {
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
              listUsuarios();
            });
        }
      });
    }
  } catch (e) {}
});

//////////////////////////////////////////////////
// ------------ LISTAR INASISTENCIAS -------------
//////////////////////////////////////////////////

function listInasistencias() {
  tablaInasistencias.innerHTML = "";

  fetch(base_url + "/excusas/getInasistencias1")
    .then((data) => data.json())
    .then((data) => {
      /* 
      console.log(data); */
      data.forEach((inasistencia) => {
        /* idexcusa.value = inasistencia.idexcusa;
        idAprendiz.value = inasistencia.aprendices_idusuario;
        idInasistencia.value = inasistencia.registro_idusuario; */

        tablaInasistencias.innerHTML += `
                <td>${inasistencia.idregistro}</td>
                <td>${inasistencia.nombre_aprendiz}</td>
                <td>${inasistencia.fecha_inasistencia}</td>
                <td>${inasistencia.nombre_usuario}</td>
                <td>${inasistencia.estado_excusa}</td>
                <td>${inasistencia.options}</td>`;
      });
    });
}

///////////////////////////////////////////////////////////
// ---------- ADJUNTAR/EDITAR/ELIMINAR EXCUSA--------------
///////////////////////////////////////////////////////////

document.addEventListener("click", (e) => {
  try {
    let selected = e.target.closest("button").getAttribute("data-action-type"); /* 
    let idusuario = e.target.closest("button").getAttribute("rel"); */

    if (selected == "adjuntar") {
      /* 
      document.getElementById("ExcusaModalLabel").innerHTML = "Agregar Usuario"; */
      $("#subirExcusaModal").modal("show");
    }

    if (selected == "update") {
      /* 
      console.log(idAprendiz.value); */
      let idInasistencia = e.target.closest("button").getAttribute("rel");
      $("#subirExcusaModal").modal("show");
      document.getElementById("ExcusaModalLabel").innerHTML = "Actualizar Excusa";
    }

    if (selected == "delete") {
      Swal.fire({
        title: "Eliminar excusa",
        text: "¿Está seguro de eliminar esta excusa?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Sí",
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData();
          formData.append("idExcusa", idExcusa);
          console.log(formData);
          fetch(base_url + "/excusas/deleteExcusa", {
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
              listUsuarios();
            });
        }
      });
    }
  } catch (e) {}
});

/////////////////////////////////////////////////////////
// ---------- LIMPIAR FORMULARIO AL CERRAR --------------
/////////////////////////////////////////////////////////

function limpiarFormulario() {
  frmExcusas.reset();
}

btnCerrar.addEventListener("click", limpiarFormulario);
btnEquis.addEventListener("click", limpiarFormulario);

///////////////////////////////////////////////
// -------------- CARGAR DATOS ----------------
///////////////////////////////////////////////

window.addEventListener("DOMContentLoaded", (e) => {
  listInasistencias();
  listExcusas();
});

///////////////////////////////////////////////
// ------------- ENVIO DE DATOS ---------------
///////////////////////////////////////////////

frmExcusas.addEventListener("submit", (e) => {
  e.preventDefault();
  frmData = new FormData(frmExcusas);
  console.log(frmExcusas.idAprendiz);
  console.log(frmData);

  fetch(base_url + "/excusas/setExcusas", {
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
        frmExcusas.reset();
        $("#subirExcusaModal").modal("hide");
        listInasistencias();
      }
    });
});
